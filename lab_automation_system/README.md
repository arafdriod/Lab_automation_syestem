Lab Automation System - Ready to run (PHP + MySQL)
-------------------------------------------------
What's included:
- config.php            (DB connection)
- index.php             (Home / Products list)
- add_product.php       (Add new product)
- add_test.php          (Add test record for a product)
- search.php            (Advanced search)
- view_product.php      (View product details & tests)
- edit_product.php      (Edit product)
- edit_test.php         (Edit test)
- delete.php            (Delete handler)
- assets/ (uses CDN for Bootstrap & DataTables)
- db.sql                (SQL to create database + sample data)
- docs/Project_Report.md (Short documentation)

How to run:
1. Put this folder in your web server root (e.g., htdocs or www).
2. Create a MySQL database (e.g., lab_automation).
3. Import db.sql into the database.
4. Update database credentials in config.php.
5. Open index.php in your browser.

Notes about IDs:
- product_id is a unique 10-character code generated automatically.
- test_id is a unique 12-character code generated automatically.
