
DROP TABLE IF EXISTS `erp_node`;
CREATE TABLE IF NOT EXISTS `erp_node` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `pid` smallint(6) unsigned NOT NULL DEFAULT '0' ,
  `name` varchar(20) NOT NULL DEFAULT '' ,
  `title` varchar(50) NOT NULL DEFAULT '' ,
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0' ,
  PRIMARY KEY (`id`)
);


INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("1", "0", "Supplier", "Supplier Management", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("2", "1", "index", "List", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("3", "1", "form", "Add/Edit Form", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("4", "1", "submit", "Submit adding/changing", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("5", "1", "delete", "Delete", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("6", "0", "Dept", "Department Management", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("7", "6", "index", "List", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("8", "30", "index", "Query", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("9", "6", "submit", "Submit adding/changing", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("10", "6", "delete", "Delete", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("11", "0", "Staff", "Staff Management", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("12", "11", "index", "List", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("13", "11", "form", "Add/Edit Form", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("14", "11", "submit", "Submit adding/changing", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("15", "11", "update", "Disable/Enable Staff", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("16", "0", "Category", "Category Management", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("17", "16", "index", "List", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("18", "16", "submit", "Submit adding/changing", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("19", "16", "delete", "Delete", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("20", "0", "Product", "Component Management", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("21", "20", "index", "List", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("22", "20", "form", "Add/Edit Form", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("23", "20", "submit", "Submit adding/changing", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("24", "20", "delete", "Delete", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("25", "0", "Board", "Board Management", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("26", "25", "index", "List", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("27", "25", "form", "Add/Edit Form", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("28", "25", "submit", "Submit adding/changing", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("29", "25", "delete", "Delete", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("30", "0", "Inventory", "Inventory Query", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("31", "0", "Setting", "Options Setting", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("32", "0", "ProductIn", "Inventory Input Management", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("33", "31", "index", "List", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("34", "31", "submit", "Submit adding/changing", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("35", "31", "delete", "Delete", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("36", "32", "index", "Product Entering List", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("37", "32", "returns", "Product Return List ", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("38", "32", "confirm", "Confirm the Entering/Return", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("39", "32", "form", "Add/Edit Form", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("40", "32", "submit", "Submit adding/changing", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("41", "32", "delete", "Delete", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("42", "0", "Role", "Role Management", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("43", "42", "index", "List", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("44", "0", "ProductOut", "Product Output Management", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("45", "44", "apply", "Fixed assets applying", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("46", "44", "transfer", "Assets transfer", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("47", "44", "submit", "Submit adding/changing", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("48", "44", "release", "Assets release", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("49", "44", "form", "Add/Edit form", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("50", "44", "select", "Selection popup", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("51", "44", "delete", "Delete", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("52", "0", "Location", "Location Setting", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("53", "0", "Node", "Node Setting", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("54", "52", "index", "List", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("55", "52", "submit", "Submit adding/changing", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("56", "52", "delete", "Delete", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("57", "53", "index", "List", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("58", "53", "update", "Update", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("59", "20", "select", "Selection popup", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("60", "32", "fixed", "Entering fixed assets", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("61", "32", "floating", "Entering floating assets", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("62", "32", "select", "Selection popup", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("63", "44", "applyFloating", "Floating assets applying", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("64", "44", "scrap", "Assets scrap", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("65", "44", "back", "Assets return", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("66", "44", "confirm", "Confirm request", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("67", "42", "add", "Add role", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("69", "42", "edit", "Edit role", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("70", "42", "update", "Enable/Disable role", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("71", "42", "delete", "Delete", "0");
INSERT INTO `erp_node` (`id`, `pid`, `name`, `title`, `level`) VALUES("72", "11", "profile", "Edit personal profile", "0");
