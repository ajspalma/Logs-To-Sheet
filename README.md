# Logs to Sheets

Get laravel error logs (production.ERROR) summary and upload automatically in Google Sheets.  

### Setup 

Install the Google Client Library.
```sh
$ composer require google/apiclient:^2.0 
```
then, run this php command in the current directory to create the env file.
```sh
$ php run.php
```

### Get your Google Credential

Go to [Google Developer Console](https://console.developers.google.com) then create new project then click Enable APIs and Services > Select Google Sheets and click Enable then create and download your credentials and put it inside `/credentials`  folder.

### Configuration

Open your `.env` file then add your the google sheets ID you want to add rows. For example:
```sh
GOOGLE_SHEETS_ID=XXXXXXXXXXXXXXXXXXXXXXXXXXXX
```
then the name of the credentials.json
```sh
GOOGLE_SHEETS_CREDENTIAL=credentials
```
finally, the sheet name
```sh
GOOGLE_SHEETS_NAME=Sheet_0
```