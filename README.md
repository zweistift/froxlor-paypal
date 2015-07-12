# froxlor-paypal.

Hi!

I created a AddOn / Plugin for Foxlor with wich you can enable PayPal subscriptions in Froxlor. You clients can log in to their accounts an press "Subscripe with Paypal" and it automaticly shows you and them if their hosting-subscription is payed.

It looks like this:




###Prerequisites
execute sql-preparations.sql in mysql with some privileges.
then the DB is fit.
##Create IPN Listener
Create a Paypal Business Acount and create a "instant payment notification" server.

Create some subscription Buttons and save the code of the buttons place.

##Add
```
<?php
?>
```
![ScreenShot](https://raw.githubusercontent.com/zweistift/froxlor-paypal/master/img/screens.png)
![ScreenShot](https://raw.githubusercontent.com/zweistift/froxlor-paypal/master/img/screens2.png)












