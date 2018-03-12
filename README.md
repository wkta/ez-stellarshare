# ez-stellarshare
a simple "lumen dividend" payment service

The current software takes the form of an add-on built on top of
the PHP stellar-api by "CryptoZulu" ver. 0.6.0 (c.f. the dedicated folder).
You need composer to complete this sub-folder with all its dependencies.

**QUICK TIP**
To use this service without installing, go to: https://gaudia-tech.com/ez-stellarshare


## how to use EZ-stellarshare?

1.  you designate a token (or custom asset) existing on the Stellar network; its units will play the role of shares, just like in a company.
Optionally you specify a blacklist (1…N stellar accounts to be ignored)
2.  you provide a temporary Stellar account containing funds (lumen) you wish to distribute,
3.  the software takes care of paying the lumen dividend, that is the lumen amount ought to be paid to each token owner based on how much he/she owns.


## example

Imagine I want to make a gift of 5 XLM to all HUG token owners.
Thanks to the ez-stellarshare service, here's what I can do in a few clicks:

1.  Lookup the HUG token via stellar.expert to find who owns HUG tokens, copy-paste owners' adresses to a file owners0.txt
2.  add the distributing account GCQUV7WA4SP3LNTRDOBSURENX6WA5JU7Q5B54Y5I2G4IRTGG2IZ6M72M to an ignore list in the form of the ignore_list0.txt file
3.  designate the HUG token as the reference for evaluating shares and provide the secret key for a temporary account that holds precisely 5.0 + 1.0606 XLM. The +1.10606 part represents an amount consumed as service fees (EZ-stellarshare is an online service that requires a running HTTPS server).
4.  press the "YES" button on the proceed.php page
5.  based on how much HUG each account owns, each account will receive a fraction of the 4.995XLM that are being distributed.
This account for example:
GBJMOL4NXA75DJRPEQ6NUXPKAGQA36OSDGYGOV2FCBSHRSOG22XXGYQI
has now 5.1333361 HUGs, whereas 29.500003 HUGs have been sold by the distributing account.
Therefore, account GBJMOL…GYQI owns ~17.4011% of all HUG tokens sold.
(in other words "tokens sold" equal total token supply minus what's owned by ignored accounts).
Thus, the GBJMOL…GYQI account will receive ~0.870XLM

This payment operation was done in practice on the Stellar network publicNet,
on march 12th 2018 at approx. 10:22 AM (GMT).
The temporary account I used was:
GBLF43DBJMP7TPAQSAHXINGJDHOIHDCIK65X7N27CBZLLOI6ZTZRVIPY
Check the payment log: 
https://stellar.expert/explorer/public/account/GBLF43DBJMP7TPAQSAHXINGJDHOIHDCIK65X7N27CBZLLOI6ZTZRVIPY

All computation and payment to each token owner are handled automatically.