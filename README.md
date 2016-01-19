Kuzman_ProductFaq
==========================

Summary
------------------------

Magento 1 Extension that will allow customers to view common FAQ’s based on the product they are viewing.
If they don’t see what they are looking for, they can submit a question via a form which can be approved and answered by the admin. 


Features:
-------------------------

•	Add question form on PDP page to allow customer to ask questions related to the product 
•	Adds list of the Frequently Asked Questions on the PDP page (accordion)
•	Allows site administrator to create Question Groups
•	Allows site administrator to easily answer and approve questions and assign them to Question Group.
•	Allows site administrator to create new questions and assign them to Question Group.
•	Supports multiple stores


Configuration
------------------------
 
  SYSTEM > Configuration > Kuzman Modules > General > Product FAQ  
 
        Enable - Yes/No
      

Administration
------------------------

 Catalog > Product FAQ > Manage Questions  
 Catalog > Product FAQ > Manage Question Groups 


Installation:
-------------------------
1. Clear the store cache under var/cache, var/full_page_cache and all cookies for your store domain. Disable compilation if enabled. This step eliminates almost all potential problems. It’s necessary since Magento uses cache heavily.
2. Backup your store database and web directory.
3. Download and unzip extension contents on your computer and navigate inside the extracted folder.
4. Using your FTP client upload content of ”app” directory to “app” directory inside your store root.
5. Using your FTP client upload csv filr in the shell directory.
8. Enable Product FAQ (SYSTEM > Configuration > Kuzman Modules > General > Product FAQ)


Uninstall:
-------------------------
- You can safely remove the extension files from your store.


Notes:
-------------------------
- Tested on Enterprise Edition 1.14.1.0 and Community Edition 1.9.2.2
