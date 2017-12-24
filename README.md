# ChatSystem
A simple social media website

First of all, I'd like to thank you for visiting my reposity.

To use this repository you need:

1. Web server e.q. (Apache)
2. PHP5 with MySQLI
3. Javascript and JQuery
4. Internet Browser e.q. (Google Chrome)
5. MySQL Server

Also, you need to set the database called (chatsystem) in the localhost
host with the following tables:

1. *users*(**ID**, fname, lname, dob, gdr, email, phone, uname, pswd)
2. *prof_imgs*(**piID**, uID, img, potime)
3. *curr_prof_img*(**uID**, piID, pitime)
4. *freind_requests*(**frID**, uID1, uID2, stat, rqtime, rptime)
5. *friends*(**fID**, uID1, uID2, ftime)
6. *posts*(**poID**, uID, poimg, potext, potime)
7. *comments*(**coID**, poID, uID, cotext, cotime)
8. *likes*(**lID**, poID, uID, ltime)
9. *shares*(**sID**, poID1, poID2, uID, ltime)
10. *chats*(**cID**, uID1, uID2, msg, ctime, stat)


You can create the database with those tables by running the script
in the php file in this path "/utilities/init_database.php"