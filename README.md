# scraperEnvoyDeploy

Laravel Envoy deploy script for scraper. Script utilizes envoys slack directive for notifications to slack channel of deploy status. Script does not include any commands for sensitive data so all sensitive data needs to be included via ssh connection to remote server between task breaks.

## Install 
`git clone git@github.com:SapioBeasley/scraperEnvoyDeploy.git`
`cd scraperEnvoyDeploy`

## Run procedures

**Rinse and repeat for each remote server you are deploying** <br />
The below commands are assuming you have a connection alias named 'beasley', so feel free to edit as it applies to your ~/.ssh/config

`envoy run config --server=beasley --job=2` <br />
*Read prompt and edit required files* <br />
**What is happening?** Connect to server alias beasley and run the @task('config')

`envoy run clone --server=beasley --job=2` <br />
*Read prompt and edit required files* <br />
**What is happening?** Connect to server alias beasley and run the @task('clone')

`envoy run scrape --server=beasley --job=2` <br />
*Read prompt and edit required files* <br />
**What is happening?** Connect to server alias beasley and run the @task('scrape')
