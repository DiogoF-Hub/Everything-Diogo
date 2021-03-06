DROP DATABASE ProductsDatabase;
create database ProductsDatabase;
use ProductsDatabase;

CREATE TABLE LANGUAGE (
    IDLang int not null AUTO_INCREMENT,
    NameLang VARCHAR(50),
    PRIMARY KEY(IDLang)
);

CREATE TABLE AvailableCountries (
    countryId int NOT NULL AUTO_INCREMENT,
    CoutryNameID VARCHAR(255),
    PRIMARY KEY(countryId)
);

CREATE TABLE AvailableCountriesNames (
    AvailableCountriesNamesID INT NOT NULL AUTO_INCREMENT,
    NameCountry VARCHAR(255),
    countryId int NOT NULL,
    IDLang INT NOT NULL,
    PRIMARY KEY(AvailableCountriesNamesID),
    FOREIGN KEY(IDlang) REFERENCES LANGUAGE(IDLang),
    FOREIGN KEY(countryId) REFERENCES AvailableCountries(countryId)
);

INSERT INTO LANGUAGE(NameLang) VALUES("English");
INSERT INTO LANGUAGE(NameLang) VALUES("Portuguese");


INSERT INTO AvailableCountries (CoutryNameID) VALUES("");
INSERT INTO AvailableCountries (CoutryNameID) VALUES("France");
INSERT INTO AvailableCountries (CoutryNameID) VALUES("Luxembourg");
INSERT INTO AvailableCountries (CoutryNameID) VALUES("Germany");

INSERT INTO AvailableCountriesNames (NameCountry, countryId, IDLang) VALUES("", 1, 1);
INSERT INTO AvailableCountriesNames (NameCountry, countryId, IDLang) VALUES("France", 2, 1);
INSERT INTO AvailableCountriesNames (NameCountry, countryId, IDLang) VALUES("Luxembourg", 3, 1);
INSERT INTO AvailableCountriesNames (NameCountry, countryId, IDLang) VALUES("Germany", 4, 1);


INSERT INTO AvailableCountriesNames (NameCountry, countryId, IDLang) VALUES("", 1, 2);
INSERT INTO AvailableCountriesNames (NameCountry, countryId, IDLang) VALUES("França", 2, 2);
INSERT INTO AvailableCountriesNames (NameCountry, countryId, IDLang) VALUES("Luxemburgo", 3, 2);
INSERT INTO AvailableCountriesNames (NameCountry, countryId, IDLang) VALUES("Alemanha", 4, 2);

create TABLE Users(
    UserID INT NOT NULL AUTO_INCREMENT,
    FirstName VARCHAR(50),
    LastName VARCHAR(50),
    UserName VARCHAR(30) UNIQUE,
    Email VARCHAR(50),
    UserPassword VARCHAR(255),
    Chart VARCHAR(500),
    UserType VARCHAR(50),
    ProfilePic VARCHAR(255),
    JoinDate DATE,
    DateOfBirth DATE,
    Civility VARCHAR(3),
    FirstLineAddress VARCHAR(255),
    HouseNumber INT,
    SecondLineAddress VARCHAR(255),
    PostalCode VARCHAR(50),
    City VARCHAR(255),
    countryId int NOT NULL,
    Primary Key(UserID),
    FOREIGN KEY(countryId) REFERENCES AvailableCountries(countryId)
);


CREATE TABLE Products (
    ProductsID int not null AUTO_INCREMENT,
    ImageLink VARCHAR(255),
    ProductNameFull VARCHAR(255),
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


CREATE TABLE Orders(
    OrderID VARCHAR(500),
    UserID INT NOT NULL,
    StatusOrder INT NOT NULL,
    PRIMARY KEY(OrderID),
    FOREIGN KEY(UserID) REFERENCES Users(UserID)
);


CREATE TABLE ListOrder(
    ListID INT NOT NULL AUTO_INCREMENT,
    OrderID VARCHAR(500),
    ProductsID INT NOT NULL,
    QuantityProduct INT NOT NULL,
    PRIMARY KEY(ListID),
    FOREIGN KEY(OrderID) REFERENCES Orders(OrderID)
);


CREATE TABLE Description (
    IDdescription INT NOT NULL AUTO_INCREMENT,
    ProductsID INT NOT NULL,
    IDlang INT NOT NULL,
    Description1 VARCHAR(255),
    Description2 VARCHAR(255),
    TableDescription1 VARCHAR(255),
    TableDescription2 VARCHAR(255),
    TableDescription3 VARCHAR(255),
    PRIMARY KEY(IDdescription),
    FOREIGN KEY(ProductsID) REFERENCES Products(ProductsID),
    FOREIGN KEY(IDlang) REFERENCES LANGUAGE(IDLang)
);


CREATE TABLE ButtonsNav (
    ButtonsID INT NOT NULL AUTO_INCREMENT,
    Button VARCHAR(25),
    PRIMARY KEY(ButtonsID)
);


CREATE TABLE DescriptionNav (
    DescriptionNavID INT NOT NULL AUTO_INCREMENT,
    ButtonsID INT NOT NULL,
    IDlang INT NOT NULL,
    textDescription VARCHAR(20),
    PRIMARY KEY(DescriptionNavID),
    FOREIGN KEY(ButtonsID) REFERENCES ButtonsNav(ButtonsID),
    FOREIGN KEY(IDlang) REFERENCES LANGUAGE(IDLang)
);

INSERT INTO ButtonsNav(Button) VALUES("Home");
INSERT INTO ButtonsNav(Button) VALUES("Contact");
INSERT INTO ButtonsNav(Button) VALUES("Products");
INSERT INTO ButtonsNav(Button) VALUES("About");
INSERT INTO ButtonsNav(Button) VALUES("Login");
INSERT INTO ButtonsNav(Button) VALUES("Logout");


/*Nav bar text in diff langs*/
INSERT INTO DescriptionNav(ButtonsID, IDlang, textDescription) VALUES(1, 1, "HOME");
INSERT INTO DescriptionNav(ButtonsID, IDlang, textDescription) VALUES(1, 2, "HOME");

INSERT INTO DescriptionNav(ButtonsID, IDlang, textDescription) VALUES(2, 1, "CONTACT");
INSERT INTO DescriptionNav(ButtonsID, IDlang, textDescription) VALUES(2, 2, "CONTACTO");

INSERT INTO DescriptionNav(ButtonsID, IDlang, textDescription) VALUES(3, 1, "PRODUCTS");
INSERT INTO DescriptionNav(ButtonsID, IDlang, textDescription) VALUES(3, 2, "PRODUTOS");

INSERT INTO DescriptionNav(ButtonsID, IDlang, textDescription) VALUES(4, 1, "ABOUT");
INSERT INTO DescriptionNav(ButtonsID, IDlang, textDescription) VALUES(4, 2, "ACERCA DE");

INSERT INTO DescriptionNav(ButtonsID, IDlang, textDescription) VALUES(5, 1, "LOGIN");
INSERT INTO DescriptionNav(ButtonsID, IDlang, textDescription) VALUES(5, 2, "LOGIN");

INSERT INTO DescriptionNav(ButtonsID, IDlang, textDescription) VALUES(6, 1, "LOGOUT");
INSERT INTO DescriptionNav(ButtonsID, IDlang, textDescription) VALUES(6, 2, "LOGOUT");


/*Products*/
INSERT INTO Products (ImageLink, ProductNameFull, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('AMD%203800X','AMD Ryzen 7 3800X','8-Core 16-Threads','(3.9 GHz / 4.5 GHz)','AMD','https://www.ldlc.com/fr-lu/fiche/PB00273568.html','429','3.9 GHz','8','16');
INSERT INTO Products (ImageLink, ProductNameFull, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('MSI%202080S','MSI GeForce RTX 2080 SUPER GAMING X TRIO','8 GB','GDDR6','MSI & NVIDIA','https://www.ldlc.com/fr-lu/fiche/PB00275069.html','959','8GB','1650 MHz','250 W');
INSERT INTO Products (ImageLink, ProductNameFull, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('MSI%20X570%20Edge','MSI MPG X570 GAMING EDGE WIFI','ATX',' Socket AM4','MSI','https://www.ldlc.com/fr-lu/fiche/PB00274040.html','244','X570','AMD AM4','ATX');
INSERT INTO Products (ImageLink, ProductNameFull, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('G.Skill%20Neo%2016GB%20Ram','G.Skill Trident Z Neo','16 GB (2x 8 GB)','DDR4 3200 MHz CL16','G.Skill','https://www.ldlc.com/fr-lu/fiche/PB00275046.html','139','16 GB','(2x 8 GB)','3200 MHz');
INSERT INTO Products (ImageLink, ProductNameFull, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Cooler%20Master%20ML240P%20Mirage','Cooler Master MasterLiquid ML240P Mirage','240mm','Radiator','Cooler Master','https://www.ldlc.com/fr-lu/fiche/PB00277153.html','149','240 mm','(2x 120 mm) ARGB','LGA2066 <br> LGA2011-v3 <br> LGA2011 <br> LGA1200 <br> LGA1151 <br> LGA1150 <br> LGA1155 <br> LGA1156 <br> LGA1366 <br> LGA775 <br> TR4 <br> AM4 <br> AM3+ <br> AM3 <br> AM2+ <br> AM2 <br> FM2+ <br> FM2 <br> FM1');
INSERT INTO Products (ImageLink, ProductNameFull, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Crucial%20NVMe%201%20To','Crucial P1 M.2 PCIe NVMe 1 TB','M.2','PCIe 3.0 x4','Crucial','https://www.ldlc.com/fr-lu/fiche/PB00258881.html','144','2000 Mb/s','1700 Mb/s','M.2 - PCI-E 3.0 4x');
INSERT INTO Products (ImageLink, ProductNameFull, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Seagate%20SSHD%201To','Seagate FireCuda SSHD 1 TB','7,200RPM','3.5 inch','Seagate','https://www.ldlc.com/fr-ch/fiche/PB00213897.html','100','7200 RPM','Serial ATA 6GB/s (SATA Revision 3)','3.5 inches');
INSERT INTO Products (ImageLink, ProductNameFull, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Cooler%20Master%20V750','Cooler Master V750','80PLUS Gold','Full modular',' Cooler Master','https://www.ldlc.com/fr-lu/fiche/PB00278228.html','126','750 W','80 PLUS Gold','Yes');
INSERT INTO Products (ImageLink, ProductNameFull, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Cooler%20Master%20H500%20ARGB','Cooler Master MasterCase H500 Gris ARGB','ATX Motherboard','Heat-tempered glass','Cooler Master','https://www.ldlc.com/fr-lu/fiche/PB00316572.html','134','2x combo 2.5"/3.5" <br> 2x 2.5" <br> 7 slots PCI','2 X USB 3.0 <br> 2 X USB 2.0 <br> 1 X Headphone (Jack 3.5mm Female) <br> 1 X Micro (Jack 3.5mm Female)','3');
INSERT INTO Products (ImageLink, ProductNameFull, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Intel%20i7-9700K','Intel Core i7-9700K','8-Core 8-Threads','(3.66 GHz / 4.9 GHz)','Intel','https://www.ldlc.com/fr-lu/fiche/PB00256785.html','449','3.6 GHz','8','8');
INSERT INTO Products (ImageLink, ProductNameFull, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Zotac%203060%20Ti','ZOTAC GeForce RTX 3060 Ti AMP White Edition LHR','8 GB','GDDR6','Zotac & NVIDIA','https://www.ldlc.com/fr-lu/fiche/PB00457888.html','849','8GB','1755 MHz','240 W');
INSERT INTO Products (ImageLink, ProductNameFull, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Asus%20Z390-E','ASUS ROG STRIX Z390-E GAMING','ATX','Socket LGA1151','Asus','https://www.ldlc.com/fr-lu/fiche/PB00257248.html','279','Z390-E','Intel 1151','ATX');
INSERT INTO Products (ImageLink, ProductNameFull, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Corsair%20Vengeance%20RGB%2032GB%20Ram','Corsair Vengeance RGB PRO Series','32 GB (4x 8 GB)','DDR4 3000 MHz CL15','Corsair','https://www.ldlc.com/fr-lu/fiche/PB00250971.html','241','32 GB','(4x 8 GB)','3000 MHz');
INSERT INTO Products (ImageLink, ProductNameFull, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Corsair%20H115i%20PLATINUM','Corsair Hydro Series H115i PLATINUM','280mm','Radiator','Corsair','https://www.ldlc.com/fr-lu/fiche/PB00259822.html','179','280mm','(2x 140 mm) ARGB','AM2 <br> AM3 <br> AM4 <br> FM1 <br> FM2 <br> SP3 <br> sTR4 <br> sTRx4 <br> 1150 <br> 1151 <br> 1155 <br> 1156 <br> 1200 <br> 1366 <br> 2011 <br> 2011-v3 <br> 2066');
INSERT INTO Products (ImageLink, ProductNameFull, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Samsung%20SDD%20500GB','Samsung SSD 860 EVO','500 GB','Serial ATA 6GB/s','Samsung','https://www.ldlc.com/fr-lu/fiche/PB00243244.html','107','550Mb/s','520Mb/s','Serial ATA 6GB/s (SATA Revision 3)');
INSERT INTO Products (ImageLink, ProductNameFull, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Seagate%20HDD%204To','Seagate BarraCuda 4TB','5,400RPM','3.5 inch','Seagate','https://www.ldlc.com/fr-lu/fiche/PB00234144.html','127','5400 RPM','Serial ATA 6GB/s (SATA Revision 3)','3.5 inches');
INSERT INTO Products (ImageLink, ProductNameFull, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Seasonic%20GX%20750%20Gold','Seasonic FOCUS GX 750W','80 Plus Gold','Full modular','Seasonic','https://www.ldlc.com/fr-lu/fiche/PB00272577.html','139','750 W','80 PLUS Gold','Yes');
INSERT INTO Products (ImageLink, ProductNameFull, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Cooler%20Master%20C700M','Cooler Master COSMOS C700M','ATX Motherboard','Heat-tempered glass','Cooler Master','https://www.ldlc.com/fr-lu/fiche/PB00263063.html','479','4x combo 2.5"/3.5" <br> 4x 2.5" <br> 8 slots PCI','4 X USB 3.0 <br> 1 X USB-C 3.1 <br> 1 X Headphone (Jack 3.5mm Female) <br> 1 X Micro (Jack 3.5mm Female)','4');
INSERT INTO Products (ImageLink, ProductNameFull, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('AMD%209%203950X','AMD Ryzen 9 3950X','16-Core 32-Threads','(3.5 GHz / 4.7 GHz)','AMD','https://www.ldlc.com/fr-lu/fiche/PB00278010.html','899','3.5 GHz','16','32');
INSERT INTO Products (ImageLink, ProductNameFull, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Gigabyte%202080%20Ti%20Xtreme','Gigabyte AORUS GeForce RTX 2080 Ti Xtreme','11 GB','GDDR6','Gigabyte & NVIDIA','https://www.ldlc.com/fr-lu/fiche/PB00260928.html','1479','11GB','1770 MHz','250 W');
INSERT INTO Products (ImageLink, ProductNameFull, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Gigabyte%20X570%20AORUS%20XTREME','Gigabyte X570 AORUS XTREME','ATX','Socket AM4','Gigabyte','https://www.ldlc.com/fr-lu/fiche/PB00275169.html','849','X570','AM4','ATX');
INSERT INTO Products (ImageLink, ProductNameFull, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Corsair%20Dominator%20128GB%20RGB','Corsair Dominator Platinum RGB','128 GB (4x 32 GB)','DDR4 3200 MHz CL16','Corsair','https://www.ldlc.com/fr-lu/fiche/PB00344651.html','1039','128 GB','(4 x 32 GB)','3200 MHz');
INSERT INTO Products (ImageLink, ProductNameFull, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Cooler%20Master%20ML360P','Cooler Master MasterLiquid ML360P Silver Edition','360mm','Radiator','Cooler Master',' https://www.ldlc.com/fr-lu/fiche/PB00300128.html','199','360mm','(3x 120 mm) ARGB','775 <br> AM2 <br> AM2 + <br> 1366 <br> AM3 <br>  1156 <br> 1155 <br>  AM3 + <br> FM1 <br> 2011 <br> FM2 <br> 1150 <br> FM2 + <br> 2011-v3 <br> 1151 <br> AM4 <br> 2066 <br> sTR4 <br> SP3 <br> sTRx4 <br> 1200');
INSERT INTO Products (ImageLink, ProductNameFull, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Seagate%20SSD%20520%202To','Seagate FireCuda 520 2 TB','M.2','PCIe 4.0 x4','Seagate','https://www.ldlc.com/fr-lu/fiche/PB00281679.html','599','5000Mb/s','4400Mb/s','M.2 - PCI-E 4.0 4x');
INSERT INTO Products (ImageLink, ProductNameFull, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Seagate%20IronWolf%20Pro%2016To','Seagate IronWolf Pro 16 TB','7,200RPM','3.5 inch','Seagate','https://www.ldlc.com/fr-lu/fiche/PB00273079.html','655','7200 RPM','Serial ATA 6GB/s (SATA Revision 3)','3.5 inches');
INSERT INTO Products (ImageLink, ProductNameFull, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Corsair%20AX1600i','Corsair AX1600i','80PLUS Titanium','Full modular','Corsair','https://www.ldlc.com/fr-lu/fiche/PB00255067.html','599','1600 W','80 PLUS Titanium','Yes');
INSERT INTO Products (ImageLink, ProductNameFull, Subtitle1, Subtitle2, Company, ProductLink, Price, DetailedTable1, DetailedTable2, DetailedTable3) VALUES ('Corsair%20Obsidian%201000D','Corsair Obsidian 1000D Black','ATX Motherboard','2 Heat-tempered glass','Corsair','https://www.ldlc.com/fr-lu/fiche/PB00250525.html','599','5x 3.5" <br> 6x 2.5" <br> 10 slots PCI','4 X USB 3.0 <br> 2 X USB-C 3.1 <br> 1 X Headphone (Jack 3.5mm Female) <br> 1 X Micro (Jack 3.5mm Female)','0');




/*English desc*/
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('1', 1,'This is a CPU from','The AMD Ryzen 7 3800X Wraith Prism LED RGB (3.9 GHz / 4.5 GHz) processor is one of the first PC processors engraved in 7 nm. Its 8 cores and 16 threads, a frequency of up to 4.5 GHz and 36 MB of GameCache make it versatile, it allows you to do everything quickly and smoothly.','Clock:','Cores:','Threads:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('2', 1,'This is a GPU from','The MSI GeForce RTX 2080 SUPER GAMING X TRIO graphics card is based on the state-of-the-art NVIDIA Turing architecture. Designed for demanding gamers, this gaming graphics card features the graphics processor inherited from the RTX 2080, the NVIDIA TU104, 8 GB of GDDR6 VRAM, a 256-bit memory interface and 3072 CUDA cores for breathtaking gaming performance and exceptional graphics rendering.','VRAM:','Clock:','Watts:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('3', 1,'This is a motherboard from','Equipped with the AMD X570 chipset, the MSI MPG X570 GAMING EDGE WIFI motherboard with its AM4 socket is designed to accommodate 3rd generation AMD Ryzen processors and remains compatible with 2nd generation ones. It will make it possible to compose a Gaming configuration with the latest technological advances: PCI-Express 4.0 for graphics cards and M.2 SSDs, management of 128 GB of DDR4 RAM.','Chipset:','Socket:','Form Factor');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('4', 1,'This is RAM from','Add performance and style to your setup with the G.SKILL Trident Z Neo memory modules! Designed to support the latest processors and motherboards, they will provide you with an optimal solution for overclocking while integrating RGB LED lighting.','Capacity:','Ram Stick:','Clock:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('5', 1,'This is a water cooler from','The CoolerMaster MasterLiquid ML240P Mirage with its Low Profile double chamber pump and two 120mm Mirage RGB fans will allow you to appreciate the performance of a liquid cooling system. Discover an efficient and silent assembly with a quick installation.','Radiator:','Fans:','CPU Socket Supported:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('6', 1,'This is a SSD from','The Crucial P1 1TB SSD gives you massive storage capacity combined with NVMe PCIe technology to turn your PC into a blazing fast machine. With read and write speeds of up to 2000MB / s and 1700MB / s, you ll never have to wait.','Reading speed:','Write speed:','Interface:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('7', 1,'This is a SSHD from','Do you hate waiting for your app or game to load? FireCuda combines SSD technology with a traditional hard drive to achieve solid-state drive-like performance, while providing capabilities typical of standard drives.','Rotation speed:','Computer interface:','Form Factor:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('8', 1,'This is a PSU from','The Cooler Master 80Plus Gold V750 power supply has everything to integrate the box of demanding users: fully modular cabling, complete connectors and 16 AWG PCIe cables, very high quality Japanese components, high energy efficiency and high efficiency with 80PLUS Gold certification.','Power:','Certification:','Modulaire:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('9', 1,'This is a Case from','The Cooler Master MasterCase H500 case has a special feature that will not leave you indifferent. Indeed, it is  The case  of the moment that gives you the choice of its design. It gives you the opportunity to opt for a tempered glass front panel or a mesh panel.','Description bays:','Front panel:','Quantity of fan (s) supplied:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('10', 1,'This is a CPU from','The Intel Core i7-9700K processor offers peak performance thanks to its native frequency of 3.6 GHz (4.9 GHz in Turbo mode), its 8 Cores and 8 threads, its 12 MB cache and its 8GT / s system BUS. With a maximum thermal envelope (TDP) of only 95W, it achieves the prowess of offering high operating frequencies for low power consumption.','Clock:','Cores:','Threads:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('11', 1,'This is a GPU from','The ZOTAC GeForce RTX 3060 Ti AMP White Edition LHR graphics card features 8 GB of next-generation GDDR6 video memory. This model benefits from high operating frequencies and an improved cooling system for reliability and long-term performance.','VRAM:','Clock:','Watts:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('12', 1,'This is a motherboard from','The ASUS ROG STRIX Z390-E GAMING motherboard is made to accommodate 9th generation Intel Core processors (Intel Coffee Lake Refresh). Based on the Intel Z390 Express chipset, it will allow the assembly of a Gaming configuration equipped with a high-performance processor.','Chipset:','Socket:','Form Factor:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('13', 1,'This is RAM from','Corsair s Vengeance RGB PRO Series high-end PC memories offer the best performance and stability for next-generation platforms with high overclocking potential.','Capacity:','Ram Stick:','Clock:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('14', 1,'This is a water cooler from','Liquid cooling for the processor, the H115i PLATINUM Hydro Series is a complete kit particularly powerful for the enclosures equipped with mounts for radiator of 280 mm.','Radiator:','Fans:','CPU Socket Supported:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('15', 1,'This is a SSD from','Samsung 860 EVO SSD is designed for everyday use. You will no longer have to choose between performance and reliability and will be able to use your PC in the best conditions thanks to the association of the Samsung 3D V-NAND memory and the Samsung MJX controller.','Reading speed:','Write speed:','Interface:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('16', 1,'This is a HDD from','Opt for massive storage capacity with the Seagate BarraCuda 4TB hard drive. This line leads the market by offering the best capacities for desktops and mobile devices.','Rotation speed:','Computer interface:','Interface:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('17', 1,'This is a PSU from','Built with quality components, this Seasonic FOCUS GX Gold power supply will continuously deliver flawless voltage and exceptional reliability for long term use.','Power:','Certification:','Modulaire:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('18', 1,'This is a Case from','Cooler Master s COSMOS C700P case is ready to accommodate a high-end configuration with Mini-ITX, Micro-ATX, ATX and E-ATX compatibility.','Description bays:','Front panel:','Quantity of fan (s) supplied:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('19', 1,'This is a CPU from','The AMD Ryzen 9 3950X processor (3.5 GHz / 4.7 GHz)  is one of the first PC processors engraved in 7 nm and compatible with the PCIe 4.0 interface . The third generation Ryzen, codenamed Matisse, impresses with its  16 cores and 32 threads , a base frequency of 3.5 GHz that can climb  to 4.7 GHz and  64 MB of L3 cache and 105W  of TDP.','Clock:','Cores:','Threads:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('20', 1,'This is a GPU from','The NVIDIA GeForce RTX 2080 Ti graphics card  is based on the new ultra-innovative NVIDIA Turing GPU architecture . Aimed at the most demanding gamers, this ultra high-end gaming graphics card features the new NVIDIA TU102 graphics processor , 11 GB of GDDR6 VRAM , a 352-bit memory interface and 4352 stream processors (CUDA Cores) for gaming performance and Breathtaking graphic rendering.','VRAM:','Clock:','Watts:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('21', 1,'This is a motherboard from','The Gigabyte X570 AORUS EXTREME motherboard will be perfect for an advanced gaming configuration. Designed for 2nd and 3rd generation AMD Ryzen processors on AMD AM4 socket, it offers PCI-Express 4.0 and management of 128 GB of DDR4 RAM as well as complete network connectivity.','Chipset:','Socket:','Form Factor:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('22', 1,'This is RAM from','Corsair Dominator Platinum RGB RAM modules will ensure you the ultimate performance for new generation platforms with the added bonus of a strong overclocking potential. With nominal voltages of 1.35V, Dominator Platinum RGB DDR4 PC memories are a high-end solution.','Capacity:','Ram Stick:','Clock:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('23', 1,'This is a water cooler from','The CoolerMaster MasterLiquid ML360P Silver Edition with its double chamber pump and 360mm MasterFan MF360R fan will allow you to appreciate the performance of a liquid cooling system which also offers ARGB backlighting.','Radiator:','Fans:','CPU Socket Supported:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('24', 1,'This is a SSD from','The Seagate FireCuda 520 2TB SSD will transform your machine and take you to ultra-high performance. Benefiting from blazing speeds thanks to its PCIe 4.0 x4 interface and an endurance of 2800 TB, the FireCuda 520 embeds 3D NAND TLC.','Reading speed:','Write speed:','Interface:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('25', 1,'This is a HDD from','Choose a robust, scalable and high-performance solution with the Seagate IronWolf Pro 16TB hard drive. Designed for 1- to 24-bay business NAS, this 3.5  drive is capable of supporting a workload of multi-user environments. up to 300 TB / year.','Rotation speed:','Computer interface:','Interface:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('26', 1,'This is a PSU from','The Corsair AX1600i guarantees an efficient, continuous and ultra stable 1600W 80 PLUS Titanium power supply. With its quiet operation and high-end components, you will experience a fully modular power supply with world-class electrical performance.','Power:','Certification:','Modulaire:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('27', 1,'This is a Case from','Exceptional in every way, the Corsair Obsidian 1000D  super tour  case benefits from a sublime design and ultra-advanced features. It has the incredible ability to host two systems simultaneously and has fully controllable RGB lighting.','Description bays:','Front panel:','Quantity of fan (s) supplied:');




/*Portuguese desc*/
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('1', 2,'Isto é um processador da','O processador AMD Ryzen 7 3800X Wraith Prism LED RGB (3,9 GHz / 4,5 GHz) é um dos primeiros processadores de PC gravados em 7 nm. Seus 8 núcleos e 16 threads, uma frequência de até 4,5 GHz e 36 MB de GameCache o tornam versátil, permite fazer tudo de forma rápida e suave.','Clock:','Cores:','Threads:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('2', 2,'Isto é uma GPU da','A placa de vídeo MSI GeForce RTX 2080 SUPER GAMING X TRIO é baseada na arquitetura NVIDIA Turing de última geração. Projetada para jogadores exigentes, esta placa de vídeo para jogos apresenta o processador gráfico herdado do RTX 2080, NVIDIA TU104, 8 GB de GDDR6 VRAM, uma interface de memória de 256 bits e 3072 núcleos CUDA para desempenho de jogo de tirar o fôlego e renderização gráfica excepcional.','VRAM:','Clock:','Watts:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('3', 2,'Isto é uma Placa mãe da','Equipada com o chipset AMD X570, a placa-mãe MSI MPG X570 GAMING EDGE WIFI com soquete AM4 foi projetada para acomodar processadores AMD Ryzen de 3ª geração e permanece compatível com os de 2ª geração. Permitirá compor uma configuração Gaming com os últimos avanços tecnológicos: PCI-Express 4.0 para placas gráficas e SSDs M.2, gerenciamento de 128 GB de RAM DDR4.','Chipset:','Socket:','Formato:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('4', 2,'Isto é um water cooler da','Adicione desempenho e estilo à sua configuração com os módulos de memória G.SKILL Trident Z Neo! Projetado para suportar os mais recentes processadores e placas-mãe, eles fornecerão uma solução ideal para overclocking, integrando iluminação LED RGB.','Capacidade:','Configuração de Memória:','Clock:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('5', 2,'Isto é um water cooler da','O CoolerMaster MasterLiquid ML240P Mirage com sua bomba de câmara dupla Low Profile e duas ventoinhas Mirage RGB de 120 mm permitirão que você aprecie o desempenho de um sistema de refrigeração líquida. Descubra uma montagem eficiente e silenciosa com uma instalação rápida.','Radiador:','Ventoinhas:','Compatibilidade Socket CPU:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('6', 2,'Isto é um SSD da','O SSD Crucial P1 de 1 TB oferece uma enorme capacidade de armazenamento combinada com a tecnologia NVMe PCIe para transformar seu PC em uma máquina extremamente rápida. Com velocidades de leitura e gravação de até 2.000 MB/s e 1.700 MB/s, você nunca terá que esperar.','Velocidade de Leitura:','Velocidade de Escrita','Interface:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('7', 2,'Isto é um SSHD da','Você odeia esperar que seu aplicativo ou jogo carregue? O FireCuda combina a tecnologia SSD com um disco rígido tradicional para obter desempenho semelhante ao de uma unidade de estado sólido, ao mesmo tempo em que oferece recursos típicos de unidades padrão.','Rotação:','Interface do Computador:','Formato:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('8', 2,'Isto é uma Fonte da','A fonte de alimentação Cooler Master 80Plus Gold V750 tem tudo para integrar a caixa de usuários exigentes: cabeamento totalmente modular, conectores completos e cabos PCIe 16 AWG, componentes japoneses de altíssima qualidade, alta eficiência energética e alta eficiência com certificação 80PLUS Gold.','Capacidade:','Certificação:','Modular:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('9', 2,'Isto é um Gabinete da','O gabinete Cooler Master MasterCase H500 possui um recurso especial que não o deixará indiferente. De fato, é "O caso" do momento que lhe dá a escolha de seu design. Dá-lhe a oportunidade de optar por um painel frontal de vidro temperado ou um painel de malha.','Descrição das Baías:','Painel Frontal:','Ventoinhas pré-instaladas:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('10', 2,'Isto é um CPU da','O processador Intel Core i7-9700K oferece desempenho máximo graças à sua frequência nativa de 3,6 GHz (4,9 GHz em modo Turbo), seus 8 núcleos e 8 threads, seu cache de 12 MB e seu sistema BUS de 8GT/s. Com um envelope térmico máximo (TDP) de apenas 95W, ele alcança a proeza de oferecer altas frequências de operação para baixo consumo de energia.','Clock:','Cores:','Threads:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('11', 2,'Isto é uma GPU da','A placa de vídeo ZOTAC GeForce RTX 3060 Ti AMP White Edition LHR possui 8 GB de memória de vídeo GDDR6 de última geração. Este modelo se beneficia de altas frequências operacionais e um sistema de resfriamento aprimorado para confiabilidade e desempenho a longo prazo.','VRAM:','Clock:','Watts:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('12', 2,'Isto é uma Placa mãe da','A placa-mãe ASUS ROG STRIX Z390-E GAMING é feita para acomodar processadores Intel Core de 9ª geração (Intel Coffee Lake Refresh). Baseado no chipset Intel Z390 Express, permitirá a montagem de uma configuração Gaming equipada com um processador de alto desempenho.','Chipset:','Socket:','Formato:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('13', 2,'Isto é uma RAM da','As memórias de PC high-end Vengeance RGB PRO Series da Corsair oferecem o melhor desempenho e estabilidade para plataformas de próxima geração com alto potencial de overclock.','Capacidade:','Configuração de Memória:','Clock:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('14', 2,'Isto é um water cooler da','Refrigeração líquida para o processador, o H115i PLATINUM Hydro Series é um kit completo particularmente poderoso para os gabinetes equipados com suportes para radiador de 280 mm.','Radiador:','Ventoinhas:','Compatibilidade Socket CPU:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('15', 2,'Isto é um SSD da','O SSD Samsung 860 EVO foi projetado para uso diário. Você não terá mais que escolher entre desempenho e confiabilidade e poderá usar seu PC nas melhores condições graças à associação da memória Samsung 3D V-NAND e do controlador Samsung MJX.','Velocidade de Leitura:','Velocidade de Escrita','Interface:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('16', 2,'Isto é um HDD da','Opte por uma enorme capacidade de armazenamento com o disco rígido Seagate BarraCuda de 4 TB. Esta linha lidera o mercado oferecendo as melhores capacidades para desktops e dispositivos móveis.','Rotação:','Interface do Computador:','Formato:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('17', 2,'Isto é uma Fonte da','Construída com componentes de qualidade, esta fonte de alimentação Seasonic FOCUS GX Gold fornecerá continuamente tensão impecável e confiabilidade excepcional para uso a longo prazo.','Capacidade:','Certificação:','Modular:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('18', 2,'Isto é um Gabinete da','O gabinete COSMOS C700P da Cooler Master está pronto para acomodar uma configuração de ponta com compatibilidade Mini-ITX, Micro-ATX, ATX e E-ATX.','Descrição das Baías:','Painel Frontal:','Ventoinhas pré-instaladas:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('19', 2,'Isto é um CPU da','O processador AMD Ryzen 9 3950X (3,5 GHz / 4,7 GHz) é um dos primeiros processadores para PC gravado em 7 nm e compatível com a interface PCIe 4.0. A terceira geração Ryzen, codinome Matisse, impressiona com seus 16 núcleos e 32 threads, uma frequência base de 3,5 GHz que pode subir para 4,7 GHz e 64 MB de cache L3 e 105W de TDP.','Clock:','Cores:','Threads:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('20', 2,'Isto é uma GPU da','A placa de vídeo NVIDIA GeForce RTX 2080 Ti é baseada na nova arquitetura ultra-inovadora de GPU NVIDIA Turing. Destinada aos jogadores mais exigentes, esta placa gráfica de jogos ultra high-end apresenta o novo processador gráfico NVIDIA TU102, 11 GB de GDDR6 VRAM, uma interface de memória de 352 bits e 4352 processadores stream (CUDA Cores) para desempenho de jogos e renderização gráfica de tirar o fôlego.','VRAM:','Clock:','Watts:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('21', 2,'Isto é uma Placa mãe da','A placa-mãe Gigabyte X570 AORUS EXTREME será perfeita para uma configuração avançada de jogos. Projetado para processadores AMD Ryzen de 2ª e 3ª geração no soquete AMD AM4, oferece PCI-Express 4.0 e gerenciamento de 128 GB de RAM DDR4, além de conectividade de rede completa.','VRAM:','Clock:','Watts:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('22', 2,'Isto é uma RAM da','Os módulos de RAM Corsair Dominator Platinum RGB garantem o melhor desempenho para plataformas de nova geração com o bônus adicional de um forte potencial de overclock. Com tensões nominais de 1,35V, as memórias de PC Dominator Platinum RGB DDR4 são uma solução de ponta.','Capacidade:','Configuração de Memória:','Clock:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('23', 2,'Isto é um water cooler da','O CoolerMaster MasterLiquid ML360P Silver Edition com sua bomba de câmara dupla e ventoinha MasterFan MF360R de 360 mm permitirá que você aprecie o desempenho de um sistema de refrigeração líquida que também oferece luz de fundo ARGB.','Radiador:','Ventoinhas:','Compatibilidade Socket CPU:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('24', 2,'Isto é um SSD da','O CoolerMaster MasterLiquid ML360P Silver Edition com sua bomba de câmara dupla e ventoinha MasterFan MF360R de 360 mm permitirá que você aprecie o desempenho de um sistema de refrigeração líquida que também oferece luz de fundo ARGB.','Velocidade de Leitura:','Velocidade de Escrita','Interface:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('25', 2,'Isto é um HDD da','Escolha uma solução robusta, escalável e de alto desempenho com o disco rígido Seagate IronWolf Pro de 16 TB. Projetada para NAS de negócios de 1 a 24 baias, esta unidade de 3,5 "é capaz de suportar uma carga de trabalho de ambientes multiusuário. até 300 TB/ano.','Rotação:','Interface do Computador:','Formato:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('26', 2,'Isto é uma Fonte da','O Corsair AX1600i garante uma fonte de alimentação eficiente, contínua e ultra estável de 1600W 80 PLUS Titanium. Com sua operação silenciosa e componentes de ponta, você experimentará uma fonte de alimentação totalmente modular com desempenho elétrico de classe mundial.','Capacidade:','Certificação:','Modular:');
INSERT INTO Description (ProductsID, IDlang, Description1, Description2, TableDescription1, TableDescription2, TableDescription3) VALUES ('27', 2,'Isto é um Gabinete da','Excepcional em todos os sentidos, o case "super tour" Corsair Obsidian 1000D se beneficia de um design sublime e recursos ultra-avançados. Tem a incrível capacidade de hospedar dois sistemas simultaneamente e possui iluminação RGB totalmente controlável.','Descrição das Baías:','Painel Frontal:','Ventoinhas pré-instaladas:');





/*View*/
CREATE VIEW UserLoggedIn as SELECT FirstName, LastName, UserName, Email, UserType, ProfilePic, DATE_FORMAT(JoinDate, '%e %b %Y') AS DateJoin, DATE_FORMAT(DateOfBirth, '%e') AS DayBirth, DATE_FORMAT(DateOfBirth, '%c') AS MonthBirth, DATE_FORMAT(DateOfBirth, '%Y') AS YearBirth, Civility, FirstLineAddress, HouseNumber, SecondLineAddress, PostalCode, City, countryId from Users;

CREATE VIEW AllorderTotal as SELECT UserID, OrderID, ProfilePic, FirstName, LastName, UserName, Email, StatusOrder, SUM(Price*QuantityProduct) as TotalOrder FROM Orders NATURAL JOIN Users NATURAL JOIN ListOrder NATURAL JOIN Products GROUP BY OrderID;

CREATE VIEW orderTotalperItem as SELECT OrderID, ProductsID, ImageLink, ProductNameFull, Price, QuantityProduct, Price*QuantityProduct as totalperItem  FROM Orders NATURAL JOIN Users NATURAL JOIN ListOrder NATURAL JOIN Products;

CREATE VIEW AllOrderUser as SELECT OrderID, UserID, ProductNameFull, QuantityProduct, Price*QuantityProduct as totalperItem, Price FROM ListOrder NATURAL JOIN Orders NATURAL JOIN Users NATURAL JOIN Products;



