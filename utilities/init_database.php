<?php

echo "<h1>";

$host     = "localhost";
$username = "login";
$password = "login";

$conn = new mysqli($host, $username, $password);
if ($conn->connect_error) {
    echo "faild to connect to MySQL Server</h1>";
    exit();
}

$sql = "Create Database chatsystem";
if ($conn->query($sql) == false) {
    echo "faild to create database</h1>";
    exit();
}

$conn = new mysqli($host, $username, $password, "chatsystem");
if ($conn->connect_error) {
    echo "faild to connect to MySQL Server</h1>";
    exit();
}

$sql = "Create table users (
        ID       Int                       Not Null     Auto_Increment
        fname    varchar(30)               Not Null,
        lname    varchar(30)               Not Null,
        dob      date                      Not Null,
        gdr      Enum('Male', 'Female')    Not Null,
        email    varchar(50)               Not Null,
        phone    varchar(30),
        uname    varchar(30)               Not Null,
        pswd     varchar(255)              Not Null,
        Primary Key (lID),
        )";
if ($conn->query($sql) == false) {
    echo "faild to create table users</h1>";
    exit();
}

$sql = "Create table prof_imgs (
        piID      Int             Not Null     Auto_Increment
        uID       Int             Not Null,
        img       varchar(255)    Not Null,
        pitime    datetime        Not Null,
        Primary Key (piID),
        Foreign Key (uID) References users (ID)
        )";
if ($conn->query($sql) == false) {
    echo "faild to create table prof_imgs</h1>";
    exit();
}

$sql = "Create table curr_prof_img (
        uID     Int    Not Null     Auto_Increment,
        piID    Int    Not Null,
        Primary Key (uID),
        Foreign Key (piID) References prof_imgs (piID)
        )";
if ($conn->query($sql) == false) {
    echo "faild to create table curr_prof_img</h1>";
    exit();
}

$sql = "Create table friend_requests (
        frID      Int                                        Not Null           Auto_Increment,
        uID1      Int                                        Not Null,
        uID2      Int                                        Not Null,
        stat      Enum('wait', 'conf', 'unconf', 'block')    Default 'wait',
        rqtime    datetime                                   Not Null,
        rptime    datetime                                   Not Null,
        Primary Key (fID),
        Foreign Key (uID1) References users (ID),
        Foreign Key (uID2) References users (ID)
        )";
if ($conn->query($sql) == false) {
    echo "faild to create table friend_requests</h1>";
    exit();
}

$sql = "Create table friends (
        fID      Int         Not Null     Auto_Increment,
        uID1     Int         Not Null,
        uID2     Int         Not Null,
        ftime    datetime    Not Null,
        Primary Key (fID),
        Foreign Key (uID1) References users (ID),
        Foreign Key (uID2) References users (ID)
        )";
if ($conn->query($sql) == false) {
    echo "faild to create table friends</h1>";
    exit();
}

$sql = "Create table posts (
        poID      Int              Not Null     Auto_Increment
        uID       Int              Not Null,
        poimg     varchar(255),
        potext    text             Not Null,
        potime    datetime         Not Null,
        Primary Key (lID),
        Foreign Key (uID) References users (ID)
        )";
if ($conn->query($sql) == false) {
    echo "faild to create table posts</h1>";
    exit();
}

$sql = "Create table comments (
        coID      Int         Not Null     Auto_Increment,
        poID      Int         Not Null,
        uID       Int         Not Null,
        cotext    Text        Not Null,
        cotime    datetime    Not Null,
        Primary Key (coID),
        Foreign Key (poID) References posts (poID),
        Foreign Key (uID)  References users (ID)
        )";
if ($conn->query($sql) == false) {
    echo "faild to create table comments</h1>";
    exit();
}

$sql = "Create table likes (
        lID      Int         Not Null     Auto_Increment,
        poID     Int         Not Null,
        uID      Int         Not Null,
        ltime    datetime    Not Null,
        Primary Key (lID),
        Foreign Key (poID) References posts (poID),
        Foreign Key (uID) References users (ID)
        )";
if ($conn->query($sql) == false) {
    echo "faild to create table likes</h1>";
    exit();
}

$sql = "Create table shares (
        sID      Int         Not Null     Auto_Increment
        poID1    Int         Not Null,
        poID2    Int         Not Null,
        uID      Int         Not Null,
        ltime    datetime    Not Null,
        Primary Key (lID),
        Foreign Key (poID1) References users (poID)
        Foreign Key (poID2) References users (poID)
        Foreign Key (uID) References users (ID)
        )";
if ($conn->query($sql) == false) {
    echo "faild to create table shares</h1>";
    exit();
}

$sql = "Create table chats (
        cID      Int                       Not Null             Auto_Increment,
        uID1     Int                       Not Null,
        uID2     Int                       Not Null,
        msg      Text                      Not Null,
        ctime    datetime                  Not Null,
        stat     Enum('seen', 'unseen')    Default 'unssen',
        Primary Key (cID),
        Foreign Key (uID1) References users (ID),
        Foreign Key (uID2) References users (ID)
        )";
if ($conn->query($sql) == false) {
    echo "faild to create table chats</h1>";
    exit();
}

?>