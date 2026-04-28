# Plagiarism Detection Tool

A plagiarism detection project that compares software project documents by transforming them into comparable hash-based representations.

## About

The system distinguishes between two types of users: **Student** and **Professor**.

* **Account Management:** Upon login, users are assigned the Student role by default. Professor accounts must be added manually to the database or via database seeders.

The project features two main interfaces:

### 1. Student Interface
* View available exams.
* Submit project files in **.zip** format to participate in an exam.

### 2. Professor Interface
* Create and configure exams (defining specific rules).
* Review projects submitted by students.
* Execute the **plagiarism detection** process.

## Installation

Clone the repository:

```bash
git clone [https://github.com/NY-ANDRY/plagiat.git](https://github.com/NY-ANDRY/plagiat.git)
cd plagiat
```