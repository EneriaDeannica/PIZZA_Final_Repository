Error: Cannot add quantity in stock
Original code: admin_stock_action.php
Location: admin_dashboard section = menu (Line 380)
Solution: Just renamed or reused the original code: admin_stock_action.php
because we have an existing admin_stock.php code, so I removed the "action"
 
Error: Cannot add product / move uploaded file to this folder: "uploads" because the said folder does not exist
Original code: 
Location: admin_dashboard section = add_product (Line 514)
Solution: Either pick the existing folder named, "Pizzeria" or make a new one named, "uploads" in which I have done.

Error: Cannot add quantity in stock
Original code: admin_stock_action.php
Location: admin_menu (Line 276)
Solution: Same solution: renamed the original code: admin_stock_action.php into admin_stock.php
