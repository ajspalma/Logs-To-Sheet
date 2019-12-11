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

Go to [Google Developer Console](https://console.developers.google.com) then **create** new project then click **Enable APIs and Services** then look for **Google Sheets API** and click _Enable_. 

Under **Credentials** section, fill-out all the following details:

[1] Find out what kind of credentials you need
1. Which API are you using? - Choose **Google Sheets API**
2. Where will you be calling the API from? - Choose **Web server (e.g. node.js, Tomcat)**
3. What data will you be accessing? - Click **Application data**
4. Are you planning to use this API with App Engine or Compute Engine? - Select **No, I'm not using them**

Then click **What credentials do I need?** button.

[2] Create a service account
1. Service account name = _nameOfYourApp_
2. Role = _Project_ > _Owner_
3. Key type = _JSON_

Then click continue to download your credentials and put it inside `/credentials`  folder.

Now, copy the value of  `client_email` property inside of the credentials.json, for example: 

```sh
"client_email": "nameofyouapp@yourprojectname.iam.gserviceaccount.com"
```

Finally, open the google spreadsheet you want to use, then click share and add the value of `client_email` that was recenlty copied.

[Watch this Youtube Tutorial for detailed explanation](https://www.youtube.com/watch?v=iTZyuszEkxI)

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