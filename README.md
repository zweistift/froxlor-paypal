# froxlor-paypal
# *in development - not stable * 
Update is prepared - fully Account-Management will be integrated with some better PayPal Functions...
----------


Hi!

I created a AddOn for Foxlor with wich you can enable PayPal subscriptions for Clients. Your clients can log into their accounts, can press "Subscripe with Paypal" and it automaticly shows them if their hosting-subscription is paid.

After implementation it looks like this:

#####User's monthly rate is not paid:
![ScreenShot](https://raw.githubusercontent.com/zweistift/froxlor-paypal/master/img/screens.png)

#####User's monthly rate is paid, it offers to cancel the subscription:
![ScreenShot](https://raw.githubusercontent.com/zweistift/froxlor-paypal/master/img/screens2.png)

#Installtion

##Prerequisites
Please make sure that you use the latest stable version of Froxlor (actually it is v.0.9.33).

###Make your DB ready

Execute **sql-preparations.sql** in mysql.


###Create IPN Listener
Create a Paypal Business Acount and create a "instant payment notification" server.

Create some subscription Buttons and save the code of the buttons place.

###Copying files
Copy the file **function.getPayOverview.php** into *froxlor/lib/functions/output/*
It will be automaticly loaded into PHP at every page-visit.


I also wrote a simpler PHP Function  for mysql(i) - DB Access (Testing...). It's a little simpler than the other way. Copy the file **function.getDatabase.php** in the same Folder :: edit --> i removed it from source in v.1.0

###Edit Area File
Edit the *froxlor/customer_index.php* -File. It has some sections in it. Paste this code into the IF-Clause $page == 'overview'
```

if ($page == 'overview'){

    ... froxlor-code
    
    $PP_info = getPayOverview($userinfo);
    
    ... froxlor-code
}
```
It will call the Function with the parameter $userinfo, Froxlor stores the userdata from the actual user in it. In the Function we gonna get the Data from the client and will put it in the variable $PP_Info

###Post Variable in the Theme
We have to define where our AddOn should appear:
*froxlor/templates/Sparke/customer/index/* **index.tpl**

Just post the variable between news feed and the Details Table
```
<div class="grid-u-1-2">
    <If Settings::Get('customer.show_news_feed') == '1'>
    ...
    </if>
    
    $PP_Info
    
    <table class="dboarditem">
    ...
```



Froxlor will call the Client-Index-Theme and paste his variables in it. So we have 










####Roadmap 08-01-15:
* while creating Clients offer a ABO select schalter
* autoupdate expire && payed state





