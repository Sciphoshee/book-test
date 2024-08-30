#!/usr/bin/env bash

php ./yii gii/model \
    --tableName=* \
    --overwrite=1 \
    --color=1 \
    --interactive=0 \
    --template=myModel \
    --ns=common\\\models\\\generated\\models \
    --queryNs=common\\\models\\\generated\\query \
    --baseClass=yii\\\db\\\ActiveRecord \
    --queryBaseClass=yii\\\db\\\ActiveQuery \
    --generateQuery=1 \
    --enableI18N=0 \
    --messageCategory=common