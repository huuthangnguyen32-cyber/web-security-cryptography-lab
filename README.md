# Web Application Security: Cryptography & Penetration Testing Lab

## 📌 Project Overview
This project is a practical web security simulation focusing on the application of cryptography in web applications[cite: 3]. It demonstrates the vulnerabilities of outdated hashing algorithms, the process of exploiting them, and the implementation of modern encryption standards to protect sensitive data[cite: 3].

**Demo Video:** [https://drive.google.com/file/d/1zv1Fl9lY3RsPuQX56HDhGhiL5gHfsq2o/view?usp=sharing]

## 🛠️ Tech Stack & Environment
* **Web Server:** Windows with Laragon, PHP, MySQL[cite: 3].
* **Attacker Machine:** Kali Linux (VMware)[cite: 3].
* **Security Tools:** Sqlmap, Hashcat[cite: 3].

## 🔐 Key Features & Scenarios

### 1. Password Hashing Vulnerabilities & Defense
* **Vulnerable Implementation:** Registered users using MD5 hashing (without salt)[cite: 3].
* **Exploitation:** Utilized `sqlmap` to dump the `users` table via SQL Injection, followed by `hashcat` to successfully brute-force the MD5 hashes within seconds[cite: 3].
* **Secure Implementation:** Upgraded password storage using `Bcrypt` (with dynamic salt and cost factor), rendering brute-force attacks infeasible[cite: 3].

### 2. Sensitive Data Encryption
* Implemented **AES-256-CBC** symmetric encryption to protect users' credit card numbers before storing them in the `payments` database[cite: 3].
* Utilized `openssl_random_pseudo_bytes` to generate a unique Initialization Vector (IV) for each transaction, ensuring ciphertext randomness even for identical card numbers[cite: 3].
* Proved that even after a successful database dump via SQL Injection, the encrypted credit card data remains unreadable without the server-side secret key[cite: 3].

## 📁 Project Structure
* `/src/`: Contains all PHP files (`login.php`, `payment.php`, `register.php`, etc.) powering the vulnerable and secured web interfaces.
* `/docs/`: Detailed Vietnamese project report covering cryptographic theory and penetration testing results.
