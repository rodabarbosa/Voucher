# Voucher

The​ ​objective​ ​is​ ​to​ ​create​ ​a​ ​voucher​ ​pool​ ​microservice​ ​based​ ​in​ ​PHP using Lumen framework

#### What​ ​is​ ​a​ ​voucher​ ​pool?
- AVoucher​ ​pool​ ​is​ ​a​ ​collection​ ​of​​ ​codes​ ​that​ ​can​ ​be​ ​used​ to​ ​get​ ​discounts. 
A voucher code can only ​be​ ​used​ ​once​ and  ​there​ ​can​ ​be​ ​many​ ​recipients​ ​in​ ​a​ ​voucher​ ​pool. There for, every code must be unique.


#### Entities
#######All entities was created based on eloquent model
**Recipient**
- Id
- Name
- Email

**SpecialOffer**
- Id
- Name 
- Discount

**VoucherCode**
- Id
- Code
- Recipient_Id
- Special_Offer_Id
- Due_Date
- Used
- Used_On

**User**
###### (Eloquent default, it will be used with authentication when implemented)
- Name
- Email


##Funcionalities
- A voucher code belongs to a special offer and has expiration date.
- All data usage must be used by API Service.
- Voucher code is validate by its code and recipient's email. In​ ​Case​ ​it​ ​is​ ​valid,​ ​return​ ​the​ ​Percentage​ discount and​ ​set​ ​the​ ​date​ ​of​ ​usage.
- Endpoint to​ ​return​ ​all​ ​valid​ ​Voucher​ ​Codes​ ​with​ ​the​ ​Name​ ​of​ ​the Special​ ​Offer to a given email.


~~PS.:~~ No security has been implemented.