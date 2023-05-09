# WHM/cPanel Get a list of all emails for all accounts in .CSV format

## Description

A PHP script to output account and email address in this format:

```
accountname1,email1@domain1.com
accountname1,email2@domain1.com
accountname2,email1@domain2.com
```

## Usage

First get the script on your computer:

```
git clone https://github.com/eugenevdm/export_whm_emails
cd export_whm_emails`
composer install`
```

Then copy `.env.example` to `.env` and add your server details:

```html
HOST=https://myserver.domain.com:2087
USERNAME=
AUTH_TYPE=
PASSWORD=
```

`AUTH_TYPE` can be `hash` or `password`

If you're using `hash`, get the hash from:

    WHM-->>CLusters-->>Remote Access Key-->>Access Key For User

Then execute the script:

`php export.php`

If you want to save the information:

`php export.php > filename.csv`

## Credits

https://packagist.org/packages/gufy/cpanel-php

The inspiration for this script was found on the cPanel forum.
https://forums.cpanel.net/threads/list-all-mailboxes-email-addresses-defined-on-server.75372/
 
Additional posts and script links exist on the cPanel forum too:
https://forums.cpanel.net/threads/export-email-account-addresses.82169/

 ## Support
 
 Contact `eugene@vander.host` or +27 82 3096710 for support
  https://vander.host
 Servers, Emails, and Domain Name Registration
 