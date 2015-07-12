# froxlor-paypal

Hi!

I created a AddOn for Foxlor with wich you can enable PayPal subscriptions for Clients. Your clients can log into their accounts, can press "Subscripe with Paypal" and it automaticly shows them if their hosting-subscription is paid.

After implementation it looks like this:

#####User's monthly rate is not paid:
![ScreenShot](https://raw.githubusercontent.com/zweistift/froxlor-paypal/master/img/screens.png)

#####User's monthly rate is paid, it offers to cancle the subscription:
![ScreenShot](https://raw.githubusercontent.com/zweistift/froxlor-paypal/master/img/screens2.png)

#Installtion

##Prerequisites
Please make sure that you use the latest stable version of Froxlor (actually it is v.0.9.33).

###Make your DB ready

Execute **sql-preparations.sql** in mysql.


##Create IPN Listener
Create a Paypal Business Acount and create a "instant payment notification" server.

Create some subscription Buttons and save the code of the buttons place.

##Add
```
<?php
?>
```












