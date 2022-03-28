DROP DATABASE ProductsDatabase;
create database ProductsDatabase;
use ProductsDatabase;


CREATE TABLE Products (
    ProductsID int not null AUTO_INCREMENT,
    ImageLink VARCHAR(255),
    ProductName VARCHAR(255),
    Subtitle1 VARCHAR(255),
    Subtitle2 VARCHAR(255),
    Company VARCHAR(50),
    ProductLink VARCHAR(255),
    Price INT,
    DetailedTable1 VARCHAR(255),
    DetailedTable2 VARCHAR(255),
    DetailedTable3 VARCHAR(255),
    PRIMARY KEY(ProductsID)
);


CREATE TABLE LANGUAGE (
    IDLang int not null AUTO_INCREMENT,
    NameLang VARCHAR(50),
    PRIMARY KEY(IDLang)
);


CREATE TABLE Description (
    IDdescription INT NOT NULL AUTO_INCREMENT,
    TheIdOfProduct INT NOT NULL,
    IDlang INT NOT NULL,
    Description1 VARCHAR(255),
    Description2 VARCHAR(255),
    Description3 VARCHAR(255),
    PRIMARY KEY(IDdescription),
    FOREIGN KEY(TheIdOfProduct) REFERENCES Products(ProductsID),
    FOREIGN KEY(IDlang) REFERENCES LANGUAGE(IDLang)
);

INSERT INTO LANGUAGE(NameLang) VALUES("English");
INSERT INTO LANGUAGE(NameLang) VALUES("Portuguese");



INSERT INTO Products (ImageLink, ProductName, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('AMD%203800X', '     AMD Ryzen 7 3800X     ', '       8-Core 16-Threads       ', '       (3.9 GHz / 4.5 GHz)     ', '       AMD      ', '       https://www.ldlc.com/fr-lu/fiche/PB00273568.html        ', '429', '3.9 GHz', '8', '16');
INSERT INTO Products (ImageLink, ProductName, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('MSI%202080S', '       MSI GeForce RTX 2080S       ', '       GAMING X TRIO       ', '       8 Go GDDR6      ', '       MSI & NVIDIA      ', '       https://www.ldlc.com/fr-lu/fiche/PB00275069.html        ', '959', '8GB', '1650 MHz', '250 W');
INSERT INTO Products (ImageLink, ProductName, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('MSI%20X570%20Edge', '       MSI MPG X570       ', '       GAMING EDGE WIFI       ', '       ATX Socket AM4      ', '       MSI      ', '       https://www.ldlc.com/fr-lu/fiche/PB00274040.html        ', '244', 'X570', 'AMD AM4', 'ATX');
INSERT INTO Products (ImageLink, ProductName, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('G.Skill%20Neo%2016Gb%20Ram', '     G.Skill Trident Z Neo     ', '       16 Go (2x 8 Go)       ', '       DDR4 3200 MHz CL16     ', '       G.Skill      ', '       https://www.ldlc.com/fr-lu/fiche/PB00275046.html        ', '139', '16 GB', '(2x 8 GB)', '3200 MHz');
INSERT INTO Products (ImageLink, ProductName, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Cooler%20Master%20ML240P%20Mirage', '     Cooler Master MasterLiquid     ', '       ML240P Mirage       ', '       240mm Radiator     ', '       Cooler Master      ', '       https://www.ldlc.com/fr-lu/fiche/PB00277153.html        ', '149', '240 mm', '(2x 120 mm) ARGB', 'LGA2066 <br> LGA2011-v3 <br> LGA2011 <br> LGA1200 <br> LGA1151 <br> LGA1150 <br> LGA1155 <br> LGA1156 <br> LGA1366 <br> LGA775 <br> TR4 <br> AM4 <br> AM3+ <br> AM3 <br> AM2+ <br> AM2 <br> FM2+ <br> FM2 <br> FM1');
INSERT INTO Products (ImageLink, ProductName, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Crucial%20NVMe%201%20To', '     Crucial P1 M.2     ', '       PCIe NVMe 1 TB       ', '       PCIe 3.0 x4     ', '       Crucial      ', '       https://www.ldlc.com/fr-lu/fiche/PB00258881.html        ', '144', '2000 Mb/s', '1700 Mb/s', 'M.2 - PCI-E 3.0 4x');
INSERT INTO Products (ImageLink, ProductName, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Seagate%20SSHD%201To', '     Seagate FireCuda     ', '       SSHD 1 TB      ', '       7,200RPM - 3.5 inch     ', '       Seagate      ', '       https://www.ldlc.com/fr-ch/fiche/PB00213897.html        ', '100', '7200 RPM', 'Serial ATA 6Gb/s (SATA Revision 3)', '3.5 inches');
INSERT INTO Products (ImageLink, ProductName, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Cooler%20Master%20V750', '     Cooler Master V750     ', '       80PLUS Gold       ', '       Full modular     ', '      Cooler Master      ', '       https://www.ldlc.com/fr-lu/fiche/PB00278228.html        ', '126', '750 W', '80 PLUS Gold', 'Yes');
INSERT INTO Products (ImageLink, ProductName, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Cooler%20Master%20H500%20ARGB', '     Cooler Master H500 ARGB     ', '       ATX Motherboard       ', '       Heat-tempered glass     ', '       Cooler Master      ', '       https://www.ldlc.com/fr-lu/fiche/PB00316572.html        ', '134', '2x combo 2.5"/3.5" <br> 2x 2.5" <br> 7 slots PCI', '2 X USB 3.0 <br> 2 X USB 2.0 <br> 1 X Headphone (Jack 3.5mm Female) <br> 1 X Micro (Jack 3.5mm Female)', '3');
INSERT INTO Products (ImageLink, ProductName, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Intel%20i7-9700K', '     Intel Core i7-9700K     ', '       8-Core 8-Threads       ', '       (3.66 GHz / 4.9 GHz)     ', '       Intel      ', '       https://www.ldlc.com/fr-lu/fiche/PB00256785.html        ', '449', '3.6 GHz', '8', '8');
INSERT INTO Products (ImageLink, ProductName, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Zotac%203060%20Ti', '     Zotac Geforce RTX 3060 Ti     ', '       AMP White Edition LHR       ', '       8 Go GDDR6     ', '       Zotac & NVIDIA      ', '       https://www.ldlc.com/fr-lu/fiche/PB00457888.html        ', '849', '8GB', '1755 MHz', '240 W');
INSERT INTO Products (ImageLink, ProductName, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Asus%20Z390-E', '     ASUS ROG STRIX     ', '       Z390-E GAMING       ', '       ATX Socket LGA1151     ', '       Asus      ', '       https://www.ldlc.com/fr-lu/fiche/PB00257248.html        ', '279', 'Z390-E', 'Intel 1151', 'ATX');
INSERT INTO Products (ImageLink, ProductName, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Corsair%20Vengeance%20RGB%2032Gb%20Ram', '     Corsair Vengeance RGB     ', '       32 Go (4x 8 Go)       ', '       DDR4 3000 MHz CL15     ', '       Corsair      ', '       https://www.ldlc.com/fr-lu/fiche/PB00250971.html        ', '241', '32 GB', '(4x 8 GB)', '3000 MHz');
INSERT INTO Products (ImageLink, ProductName, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Corsair%20H115i%20PLATINUM', '     Corsair Hydro Series     ', '       H115i PLATINUM       ', '       280mm Radiator     ', '       Corsair      ', '       https://www.ldlc.com/fr-lu/fiche/PB00259822.html        ', '179', '280mm', '(2x 140 mm) ARGB', 'AM2 <br> AM3 <br> AM4 <br> FM1 <br> FM2 <br> SP3 <br> sTR4 <br> sTRx4 <br> 1150 <br> 1151 <br> 1155 <br> 1156 <br> 1200 <br> 1366 <br> 2011 <br> 2011-v3 <br> 2066');
INSERT INTO Products (ImageLink, ProductName, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Samsung%20SDD%20500Gb', '     Samsung SSD 860 EVO     ', '       SSD 500 Gb       ', '       Serial ATA 6Gb/s     ', '       Samsung      ', '       https://www.ldlc.com/fr-lu/fiche/PB00243244.html        ', '107', '550Mb/s', '520Mb/s', 'Serial ATA 6Gb/s (SATA Revision 3)');
INSERT INTO Products (ImageLink, ProductName, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Seagate%20HDD%204To', '     Seagate BarraCuda     ', '       HDD 4 TB       ', '       5,400RPM - 3.5 inch     ', '       Seagate      ', '       https://www.ldlc.com/fr-lu/fiche/PB00234144.html        ', '127', '5400 RPM', 'Serial ATA 6Gb/s (SATA Revision 3)', '3.5 inches');
INSERT INTO Products (ImageLink, ProductName, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Seasonic%20GX%20750%20Gold', '     Seasonic FOCUS     ', '       GX 750 80 Plus Gold       ', '       Full modular     ', '       Seasonic      ', '       https://www.ldlc.com/fr-lu/fiche/PB00272577.html        ', '139', '750 W', '80 PLUS Gold', 'Yes');
INSERT INTO Products (ImageLink, ProductName, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Cooler%20Master%20C700M', '     Cooler Master C700M     ', '       ATX Motherboard      ', '       Heat-tempered glass     ', '       Cooler Master      ', '       https://www.ldlc.com/fr-lu/fiche/PB00263063.html        ', '479', '4x combo 2.5"/3.5" <br> 4x 2.5" <br> 8 slots PCI', '4 X USB 3.0 <br> 1 X USB-C 3.1 <br> 1 X Headphone (Jack 3.5mm Female) <br> 1 X Micro (Jack 3.5mm Female)', '4');
INSERT INTO Products (ImageLink, ProductName, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('AMD%209%203950X', '     AMD Ryzen 9 3950X     ', '       16-Core 32-Threads       ', '       (3.5 GHz / 4.7 GHz)     ', '       AMD      ', '       https://www.ldlc.com/fr-lu/fiche/PB00278010.html        ', '899', '3.5 GHz', '16', '32');
INSERT INTO Products (ImageLink, ProductName, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Gigabyte%202080%20Ti%20Xtreme', '     Gigabyte GeForce RTX 2080 Ti     ', '       AORUS Xtreme 11G       ', '       11 Go GDDR6     ', '       Gigabyte & NVIDIA     ', '       https://www.ldlc.com/fr-lu/fiche/PB00260928.html        ', '1479', '11GB', '1770 MHz', '250 W');
INSERT INTO Products (ImageLink, ProductName, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Gigabyte%20X570%20AORUS%20XTREME', '     Gigabyte X570     ', '       AORUS XTREME       ', '       ATX Socket AM4     ', '       Gigabyte      ', '       https://www.ldlc.com/fr-lu/fiche/PB00275169.html        ', '849', 'X570', 'AM4', 'ATX');
INSERT INTO Products (ImageLink, ProductName, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Corsair%20Dominator%20128Gb%20RGB', '     Corsair Dominator Platinum     ', '       128 Go (4x 32 Go)      ', '       DDR4 3200 MHz CL16     ', '       Corsair      ', '       https://www.ldlc.com/fr-lu/fiche/PB00344651.html        ', '1039', '128 GB', '(4 x 32 GB)', '3200 MHz');
INSERT INTO Products (ImageLink, ProductName, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Cooler%20Master%20ML360P', '     Cooler Master     ', '       ML360P Silver Edition       ', '       360mm Radiator     ', '       Cooler Master      ', '      https://www.ldlc.com/fr-lu/fiche/PB00300128.html        ', '199', '360mm', '(3x 120 mm) ARGB', '775 <br> AM2 <br> AM2 + <br> 1366 <br> AM3 <br>  1156 <br> 1155 <br>  AM3 + <br> FM1 <br> 2011 <br> FM2 <br> 1150 <br> FM2 + <br> 2011-v3 <br> 1151 <br> AM4 <br> 2066 <br> sTR4 <br> SP3 <br> sTRx4 <br> 1200');
INSERT INTO Products (ImageLink, ProductName, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Seagate%20SSD%20520%202To', '     Seagate FireCuda 520     ', '       SSD 2 TB       ', '       PCIe 4.0 x4     ', '       Seagate      ', '       https://www.ldlc.com/fr-lu/fiche/PB00281679.html        ', '599', '5000Mb/s', '4400Mb/s', 'M.2 - PCI-E 4.0 4x');
INSERT INTO Products (ImageLink, ProductName, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Seagate%20IronWolf%20Pro%2016To', '     Seagate IronWolf Pro     ', '       HDD 16 TB       ', '       7,200RPM - 3.5 inch     ', '       Seagate      ', '       https://www.ldlc.com/fr-lu/fiche/PB00273079.html        ', '655', '7200 RPM', 'Serial ATA 6Gb/s (SATA Revision 3)', '3.5 inches');
INSERT INTO Products (ImageLink, ProductName, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Corsair%20AX1600i', '     Corsair AX1600i     ', '       80PLUS Titanium       ', '       Full modular     ', '       Corsair      ', '       https://www.ldlc.com/fr-lu/fiche/PB00255067.html        ', '599', '1600 W', '80 PLUS Titanium', 'Yes');
INSERT INTO Products (ImageLink, ProductName, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Corsair%20Obsidian%201000D', '     Corsair Obsidian 1000D Noir     ', '       ATX Motherboard       ', '       2 Heat-tempered glass     ', '       Corsair      ', '       https://www.ldlc.com/fr-lu/fiche/PB00250525.html        ', '599', '5x 3.5" <br> 6x 2.5" <br> 10 slots PCI', '4 X USB 3.0 <br> 2 X USB-C 3.1 <br> 1 X Headphone (Jack 3.5mm Female) <br> 1 X Micro (Jack 3.5mm Female)', '0');