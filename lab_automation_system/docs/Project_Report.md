# Project Report - Lab Automation System (Short)

## 1. Introduction
This project replaces the manual paper-based testing record system for SRS Electrical Appliances with a web-based application.

## 2. Objectives
- Maintain product and testing records in a database.
- Generate unique product and test IDs automatically.
- Provide search and reporting capabilities.
- Reduce errors and speed up record retrieval.

## 3. System Design (Brief)
- PHP (server-side), MySQL (database), Bootstrap + DataTables (frontend)
- Tables: products, tests
- product_id format: PRD + 7-digit zero-padded number (unique)
- test_id format: product_id + 3-digit counter

## 4. How to use
- Add products using 'Add Product'
- Add tests using 'Add Test' (select product)
- View product details and tests, edit/delete as needed
- Use Advanced Search for finding records

## 5. Future Enhancements
- User authentication + roles (tester, admin)
- File attachments (test reports)
- Export reports (PDF/Excel)
- Audit logs
