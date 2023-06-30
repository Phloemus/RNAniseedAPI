import psycopg2
import numpy as np
import pandas as pd
import anndata as ad
import scanpy as sc
import sys

############################ Argument checking ################################################


if len(sys.argv) != 2:
    sys.exit(1)
else:
    h5adFileName = sys.argv[1] 


############################ Matrix database extraction #######################################


conn = psycopg2.connect(database="aniseed_chado_db", host="localhost", user="brieucq", password="brieucq329", port="5432")

## create the cursors that will store the extracted data
cursorStages = conn.cursor()
cursorGenenames = conn.cursor()
cursorCounts = conn.cursor()
cursorCellTypes = conn.cursor()
cursorNbExtractedCells = conn.cursor()
cursorNbExtractedGenes = conn.cursor()

## get the required data from the database
cursorStages.execute("SELECT stage FROM sc_rna_cells")
cursorGenenames.execute("SELECT name FROM sc_rna_genes")
cursorCounts.execute("SELECT value FROM sc_rna_counts")
cursorCellTypes.execute("SELECT type FROM sc_rna_cells")

## get the number of extracted cells
cursorNbExtractedCells.execute("SELECT count(*) FROM sc_rna_cells")
cursorNbExtractedGenes.execute("SELECT count(*) FROM sc_rna_genes")
nbExtractedCells = cursorNbExtractedCells.fetchone()[0]
nbExtractedGenes = cursorNbExtractedGenes.fetchone()[0]

## put the counts into a np array
countsNpArray = np.array(cursorCounts.fetchall())

## reshape the array to become meet [gene X cell] dimention
countsMatrix = np.reshape(countsNpArray, (nbExtractedCells, nbExtractedGenes))

## matrix conversion to pandas dataframe
countsMatrixDf = pd.DataFrame(countsMatrix)


############################ Data conversion to h5ad #########################################


## creating a AnnData object containing the transcription matrix
adata = ad.AnnData(countsMatrixDf)

## saving the countsMatrixDf into a file
## Doesn't work, prevent to check if the dataframe format used here is similar to the one used during 
## preprocessing tests and the h5ad creation tests
##### countsMatrixDf.to_csv('cxg_data/counts-df.csv', sep=';', index=False, header=False) ## 


## obs names and var names
adata.obs_names = [f"Cell_{i:d}" for i in range(adata.n_obs)]
geneNames = np.array(cursorGenenames.fetchall())
geneNames = [f"{geneNames[i][0]}" for i in range(len(geneNames))]
adata.var_names = [f"{geneNames[i]}" for i in range(adata.n_vars)]

################################################################# TODO: Adding the stages

## USING stage Cursor

## adding the stage 'label' containing multiple different 
## categories 
obsTemp = []
cellStages = np.array(cursorStages.fetchall())
for i in range(adata.n_obs):
    tempVal = ""
    if int(cellStages[i][0]) == 2:
        tempVal = "stage 1 (2 cells)"
    if int(cellStages[i][0]) == 4:
        tempVal = "stage 2 (4 cells)"
    if int(cellStages[i][0]) == 8:
        tempVal = "stage 3 (8 cells)"
    if int(cellStages[i][0]) == 16:
        tempVal = "stage 4 (16 cells)"
    if int(cellStages[i][0]) == 32:
        tempVal = "stage 5 (32 cells)"
    if int(cellStages[i][0]) == 44:
        tempVal = "stage 6 (44 cells)"
    if int(cellStages[i][0]) == 64:
        tempVal = "stage 7 (64 cells)"
    obsTemp.append(tempVal)
adata.obs["stages"] = pd.Categorical(obsTemp)

################################################################# END Adding the stages


## normalizations
sc.pp.normalize_total(adata, target_sum=1e4)
sc.pp.log1p(adata)
sc.pp.highly_variable_genes(adata, min_mean=0.0125, max_mean=3, min_disp=0.5)
### sc.pl.highly_variable_genes(adata) #### intermediate visualization

adata.raw = adata

## Scale
adata = adata[:, adata.var.highly_variable]
sc.pp.scale(adata, max_value=10)

## PCA
sc.tl.pca(adata, svd_solver='arpack')

## Print PCs
# sc.pl.pca_variance_ratio(adata, log=True) #### intermediate visualization

## Neighbors
sc.pp.neighbors(adata, n_neighbors=10, n_pcs=40)

## UMAP
####! the umap doesn't look like the one generated with the same data previously
sc.tl.umap(adata)


################################################################################## TODO: Adding territory 
## Working ##

ct8 = []
ct16 = []
cellTypes = np.array(cursorCellTypes.fetchall())
for i in range(adata.n_obs):
    if int(cellStages[i][0]) == 8:
        ct8.append(cellTypes[i][0])
    else:
        ct8.append("not a stage 3 cell type")
    if int(cellStages[i][0]) == 16:
        ct16.append(cellTypes[i][0])
    else:
        ct16.append("not a stage 4 cell type")
adata.obs['stage 3 (8 cells)'] = pd.Categorical(ct8)
adata.obs['stage 4 (16 cells)'] = pd.Categorical(ct16)

################################################################################## END Adding territory


## writing a h5ad file from the adata object
adata.write(h5adFileName)


conn.close()