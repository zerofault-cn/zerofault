
INSERT INTO `erp_location` (`id`, `name`, `descr`) VALUES (1, 'Local', 'Default Storage');

INSERT INTO `erp_options` (`id`, `type`, `name`, `code`, `sort`) VALUES
(1, 'character', 'Agent', '', 1),
(2, 'character', 'Manufacture', '', 2),
(3, 'character', 'Other', '', 3),
(4, 'payment_terms', 'Due 20th Of the Following Month', '', 1),
(5, 'payment_terms', 'Due By End Of The Following Month', '', 2),
(6, 'payment_terms', 'Payment due within 7 days', '', 3),
(7, 'payment_terms', 'Cash Only', '', 4),
(8, 'tax', 'Default tax group', '', 1),
(9, 'tax', 'Ontario', '', 2),
(10, 'tax', 'UK Inland Revenue', '', 3),
(11, 'currency', 'Australian Dollars', 'AUD', 1),
(12, 'currency', 'Swiss Francs', 'CHF', 2),
(13, 'currency', 'Euro', 'EUR', 3),
(14, 'currency', 'Pounds', 'GBP', 4),
(15, 'currency', 'US Dollars', 'USD', 5),
(16, 'currency', 'China Yuan', 'CNY', 6),
(17, 'unit', 'pcs', '', 1),
(18, 'unit', 'each', '', 2),
(19, 'unit', 'set', '', 3),
(20, 'status', 'OK', '', 1),
(21, 'status', 'Bad', '', 2),
(22, 'status', 'Need to Repair', '', 3);


INSERT INTO `erp_staff` (`id`, `dept_id`, `leader_id`, `code`, `name`, `realname`, `password`, `email`, `onboard`, `create_time`, `login_time`, `is_leader`, `status`) VALUES
(1, 0, 0, 'E0001', '~admin_name~', 'Super Admin', '~admin_pass~', '~admin_email~', CURDATE(), NOW(), NOW(), 0, 1);

INSERT INTO `erp_node` VALUES("1", "0", "Board", "Board Basic Data", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("2", "0", "Category", "Category Management", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("3", "0", "Dept", "Department Management", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("4", "0", "Location", "Location Setting", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("5", "0", "Product", "Component Basic Data", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("6", "0", "ProductIn", "Inventory Input Management", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("7", "0", "ProductOut", "Inventory output Management", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("8", "0", "Setting", "Options Setting", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("9", "0", "Staff", "Staff Management", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("10", "0", "Supplier", "Supplier Management", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("11", "1", "index", "List", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("12", "1", "form", "Form", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("13", "1", "submit", "Submit", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("14", "1", "delete", "Delete", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("15", "2", "index", "List", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("16", "2", "submit", "Submit", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("17", "2", "delete", "Delete", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("18", "3", "index", "List", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("19", "3", "submit", "Submit", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("20", "3", "delete", "Delete", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("21", "4", "index", "List", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("22", "4", "submit", "Submit", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("23", "4", "delete", "Delete", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("24", "5", "index", "List", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("25", "5", "form", "Form", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("26", "5", "submit", "Submit", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("27", "5", "delete", "Delete", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("28", "6", "fixed", "Fixed-Assets Entering", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("29", "6", "floating", "Floating-Assets Entering", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("30", "6", "reject", "Product Reject", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("31", "6", "form", "Form", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("32", "6", "submit", "Submit", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("33", "6", "confirm", "Confirm", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("34", "6", "select", "Select Basic Data", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("35", "6", "delete", "Delete", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("36", "7", "applyFixed", "Fixed-Assets Apply Management", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("37", "7", "applyFloating", "Floating-Assets Apply Management", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("38", "7", "transfer", "Transfer Management", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("39", "7", "release", "Release Management", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("40", "7", "scrap", "Scrap Management", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("41", "7", "returns", "Return management", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("42", "7", "form", "Form", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("43", "7", "submit", "Submit", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("44", "7", "confirm", "Confirm", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("45", "7", "select", "Select Basic Data", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("46", "7", "delete", "Delete", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("47", "8", "index", "List", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("48", "8", "submit", "Submit", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("49", "8", "delete", "Delete", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("50", "9", "index", "List", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("51", "9", "form", "Form", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("52", "9", "submit", "Submit", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("53", "9", "update", "Update", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("54", "9", "delete", "Delete", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("55", "10", "index", "List", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("56", "10", "form", "Form", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("57", "10", "submit", "Submit", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("58", "10", "delete", "Delete", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("59", "1", "import", "Batch Import", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("60", "0", "Leave", "Leave Type Management", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("61", "60", "index", "List", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("62", "60", "update", "Update", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("63", "60", "delete", "Delete", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("64", "0", "ProductFlow", "Assets Operation Log", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("65", "64", "index", "List", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("66", "5", "import", "Batch Import", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("67", "5", "select", "Select", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("68", "5", "info", "Info", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("69", "5", "update", "Update", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("70", "6", "enter", "Assets Entering", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("71", "6", "export", "Batch Export", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("72", "6", "import", "Batch Import", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("73", "0", "Test", "Test Log", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("74", "73", "index", "List", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("75", "73", "create", "Create Log", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("76", "73", "edit", "Edit Log", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("77", "73", "update", "Update", NULL, "0", "0");
INSERT INTO `erp_node` VALUES("78", "7", "export", "Batch Export", NULL, "0", "0");