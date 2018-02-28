# ez-stellarshare
a simple "lumen dividend" payment service

## how to use EZ-stellarshare?

1.  you designate a custom asset existing on the Stellar network; its units will play the role of shares, just like in a company.
Optionally you specify a blacklist (1…N stellar accounts to be ignored)
2.  you provide a temporary Stellar account containing funds (lumen) you wish to distribute,
3.  the software takes care of paying the lumen dividend, that is the lumen amount ought to be paid to each custom asset owner based on how much he/she owns.

## example

Imagine EZ-stellarshare is already released.
I would be the happy 1st user of EZ-stellarshare.
Here's what I could do in a few clicks:

1.  designate the HUG asset, issued by:
GD5T6IPRNCKFOHQWT264YPKOZAWUMMZOLZBJ6BNQMUGPWGRLBK3U7ZNP,
 as the reference for evaluating shares. Blacklist one account:
GCQUV7WA4SP3LNTRDOBSURENX6WA5JU7Q5B54Y5I2G4IRTGG2IZ6M72M
since it's a distributing account. Sorry, no lumen for you Jed ;-)
2.  provide the secret key for a temporary account that holds precisely 1000+1 XLM, if I wanna distribute 1000 XLM to all HUG owners. The +1 part represents a flat fee
3.  press the "pay lumen dividend" button.
Based on how much HUG each account owns, each account will receive a fraction of the 1000 XLM.
This account for example:
GBJMOL4NXA75DJRPEQ6NUXPKAGQA36OSDGYGOV2FCBSHRSOG22XXGYQI
currently holds 5.1333361 HUGs, that is ~18.667% of 27.5 HUGs,
27.5 HUGs being the total supply minus what's ignored due to the blacklist.
Thus, the GBJMOL…GYQI account will receive ~186.67 XLM.
All the computation and payment to each asset owner are automated.
