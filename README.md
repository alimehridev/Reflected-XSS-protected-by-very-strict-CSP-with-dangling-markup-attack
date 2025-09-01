# PortSwigger Lab Setup Guide

This repository contains a simple guide to set up a MySQL database for a PortSwigger lab environment. Follow the steps below to configure the lab and explore vulnerabilities like SQL Injection for educational purposes.

## Prerequisites
- PHP installed
- A web server to host the lab environment
- MySQL database manager installed
- Basic understanding of SQL and database management

## Setup Instructions

1. **Create a Database**
   - Open your MySQL database manager.
   - Create a new database named `portswigger-db`.

2. **Create the `users` Table**
   - In the `portswigger-db` database, create a table named `users`.
   - The `users` table should have the following columns:
     - `username` (string)
     - `password` (string)
     - `email` (string)

3. **Insert User Data**
   - Execute the following SQL commands to populate the `users` table:
     ```sql
     INSERT INTO `users` (`username`, `password`, `email`) VALUES ('wiener', 'peter', 'wiener@gmail.com');
     INSERT INTO `users` (`username`, `password`, `email`) VALUES ('carlos', 'carlos_password', 'hacker@evil.tld');
     ```
   - This creates two users:
     - **wiener**: password `peter`, email `wiener@gmail.com`
     - **carlos**: password `carlos_password`, email `hacker@evil.tld`

4. **Set Up a Virtual Host (Optional)**
   - To isolate this lab from other projects, configure a virtual host on your web server.
   - Ensure the virtual host points to your lab environment.

5. **Explore Vulnerabilities**
   - This lab includes vulnerabilities like SQL Injection, CSRF Attack, Dangling Markup Attack and etc.
   - Try identifying and exploiting these vulnerabilities for educational purposes.

## Notes
- This lab is designed for learning and practicing web security concepts in a controlled environment.
