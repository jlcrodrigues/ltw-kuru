DROP TABLE IF EXISTS USER;
DROP TABLE IF EXISTS REQUEST;
DROP TABLE IF EXISTS DISH; 
DROP TABLE IF EXISTS OWNER;
DROP TABLE IF EXISTS RESTAURANT;
DROP TABLE IF EXISTS REVIEW;
DROP TABLE IF EXISTS COMMENT;
DROP TABLE IF EXISTS FAVORITE_DISH;
DROP TABLE IF EXISTS FAVORITE_RESTAURANT;
DROP TABLE IF EXISTS REQUEST_DISH;

CREATE TABLE USER (
    idUser INT NOT NULL,
    firstName NVARCHAR(40)  NOT NULL,
    lastName NVARCHAR(20)  NOT NULL,
    address NVARCHAR(200),
    city NVARCHAR(40),
    country NVARCHAR(40),
    phone NVARCHAR(24),
    email NVARCHAR(60) NOT NULL,
    password NVARCHAR(40) NOT NULL,
    CONSTRAINT PK_USER PRIMARY KEY (idUser)
);

CREATE TABLE OWNER (
    idUser INT NOT NULL,
    idRestaurant INT NOT NULL,
    CONSTRAINT PK_OWNER PRIMARY KEY (idUser),
    FOREIGN KEY (idUser) REFERENCES USER,
    FOREIGN KEY (idRestaurant) REFERENCES RESTAURANT
);

CREATE TABLE REQUEST (
    idRequest INT NOT NULL,
    idUser INT NOT NULL, 
    idRestaurant INT NOT NULL, 
    state VARCHAR(15) NOT NULL,
    CONSTRAINT PK_REQUEST PRIMARY KEY (idRequest),
    FOREIGN KEY (idUser) REFERENCES USER,
    FOREIGN KEY (idRestaurant) REFERENCES RESTAURANT
);

CREATE TABLE DISH (
    idDish INT NOT NULL,
    idRestaurant INT NOT NULL,
    name VARCHAR(80) NOT NULL,
    description VARCHAR(120),
    price FLOAT NOT NULL,
    promotion INT,
    category VARCHAR(50) NOT NULL,
    CONSTRAINT PK_DISH PRIMARY KEY (idDish),
    FOREIGN KEY (idRestaurant) REFERENCES RESTAURANT
);

CREATE TABLE RESTAURANT (
    idRestaurant INT NOT NULL,
    name VARCHAR(80) NOT NULL,
    opens VARCHAR(8),
    closes VARCHAR(8),
    category VARCHAR(50),
    photo VARCHAR(150),
    address VARCHAR(200),
    CONSTRAINT PK_RESTAURANT PRIMARY KEY (idRestaurant)
);

CREATE TABLE REVIEW (
    idReview INT NOT NULL,
    idUser INT NOT NULL,
    rating INT NOT NULL,
    fullText VARCHAR(120),
    data DATE NOT NULL,
    CONSTRAINT PK_REVIEW PRIMARY KEY (idReview),
    FOREIGN KEY (idUser) REFERENCES USER
);

CREATE TABLE COMMENT (
    idComment INT NOT NULL, 
    idUser INT NOT NULL,
    idReview INT NOT NULL,
    fulltext VARCHAR(120),
    CONSTRAINT PK_COMMENT PRIMARY KEY (idComment),
    FOREIGN KEY (idUser) REFERENCES USER,
    FOREIGN KEY (idReview) REFERENCES REVIEW
);

CREATE TABLE FAVORITE_DISH (
    idUser INT NOT NULL,
    idDish INT NOT NULL,
    CONSTRAINT PK_FAV_DISH PRIMARY KEY (idUser, idDish),
    FOREIGN KEY (idUser) REFERENCES USER,
    FOREIGN KEY (idDish) REFERENCES DISH
);

CREATE TABLE FAVORITE_RESTAURANT (
    idUser INT NOT NULL,
    idRestaurant INT NOT NULL,
    CONSTRAINT PK_FAV_RESTAURANT PRIMARY KEY (idUser, idRestaurant),
    FOREIGN KEY (idUser) REFERENCES USER,
    FOREIGN KEY (idRestaurant) REFERENCES RESTAURANT
);

CREATE TABLE REQUEST_DISH (
    idRequest INT NOT NULL,
    idDish INT NOT NULL,
    CONSTRAINT PK_REQUEST_DISH PRIMARY KEY (idRequest, idDish),
    FOREIGN KEY (idRequest) REFERENCES REQUEST,
    FOREIGN KEY (idDish) REFERENCES DISH
);






/*******************************************************************************
   Populate Tables
********************************************************************************/



/* USER */


INSERT INTO USER (idUser,firstName,lastName,address,city,country,phone,email,password)
VALUES 
  (1,"Herman","Wheeler","P.O. Box 761, 2569 Euismod Rd.","Ankara","Norway","1-532-213-8573","blandit.enim.consequat@outlook.org","B47C677C-51E6-6F1F-4A24-6EA876ED26DC"),
  (2,"Oren","Gilliam","P.O. Box 543, 2547 Iaculis Rd.","Wollongong","Canada","1-516-689-3088","amet.consectetuer.adipiscing@google.com","D96C7E77-5668-0BE5-6D21-2EAB84E3F2C3"),
  (3,"Stephanie","Allen","473-601 Eros. St.","Zhejiang","United States","1-268-218-3705","molestie@google.com","B1D8A726-42C7-E1F9-24E2-53A8CCE848E6"),
  (4,"Patrick","Smith","Ap #907-7429 Aliquet, Ave","Sudhanoti","Belgium","850-4304","vulputate.nisi@outlook.ca","85A3599C-34AB-27AC-9570-72BAC5D25B30"),
  (5,"Emery","Wilson","245-8625 Odio Road","North Waziristan","Colombia","339-0869","id.sapien@yahoo.edu","BD630AA8-56C6-7362-BC3A-134D597D1492"),
  (6,"Kyra","Richard","Ap #519-4361 Tempor Rd.","Belfast","India","403-9888","phasellus@aol.couk","386C3D65-58E2-8648-6171-D35E6F7751E3"),
  (7,"Ella","Sandoval","527-6425 Vel, Rd.","Gongju","South Korea","894-8643","imperdiet@aol.edu","A751CC64-92F2-167C-0EA8-830741B12778"),
  (8,"Vivian","Jarvis","8350 Enim Avenue","Galway","Turkey","1-821-734-7845","eleifend.egestas@icloud.net","D078D432-3CB9-3501-D46A-ACB5049F280E"),
  (9,"Deborah","Green","P.O. Box 504, 1562 Fringilla, St.","Lim Chu Kang","Peru","815-6224","ipsum@hotmail.org","23A4F2EE-36AC-E64C-7C90-5677B6ED1294"),
  (10,"Curran","Schwartz","292-6749 Vehicula Ave","Khmilnyk","Vietnam","552-7540","fusce@protonmail.com","9A8A4CC6-2940-D13A-34C1-B45BF1D54C0D"),
  (11,"Lysandra","Robertson","Ap #956-4095 Sed Avenue","Bagh","Singapore","1-923-162-0428","cursus.in@protonmail.edu","C2983E24-0469-DCD7-ED7E-518EC40DD66A"),
  (12,"Adam","Frederick","Ap #350-5653 Nam Ave","Santa Cruz de Lorica","Australia","1-536-543-7127","urna.nunc@google.ca","82B5E9E7-3AAA-DB5F-C854-1AF42BE2E9E2"),
  (13,"Charde","Dean","8199 Mi Road","Popayán","New Zealand","1-610-123-1604","vel.mauris@aol.couk","350283AD-164D-0BDA-B672-67C7F1A277E2"),
  (14,"Larissa","Sandoval","824-3616 Justo Av.","Naushahro Firoze","India","130-8547","tincidunt.neque.vitae@hotmail.net","211ED3D0-FED7-4DA4-5B5B-4B4D555DB3A4"),
  (15,"Erasmus","Fitzpatrick","377-5721 Nullam Road","Western Water Catchment","Colombia","368-2722","consectetuer.adipiscing@google.org","4627BD06-510A-6B2E-D29E-092FBF310C78"),
  (16,"Martha","Vang","6840 Laoreet Road","Białystok","Turkey","1-420-357-6985","dolor@icloud.org","2E2DC4D0-CA87-E734-D9B3-B63180B5A16A"),
  (17,"Brynne","Carter","P.O. Box 714, 1212 Ac Avenue","Bruck an der Mur","Australia","1-561-482-2173","est.mauris.eu@icloud.ca","C1101886-B691-D273-0848-3568196C6187"),
  (18,"Evan","Estrada","645 Molestie Rd.","Lauro de Freitas","Brazil","576-9405","mus.proin.vel@hotmail.org","4FCB7AE4-4958-5D28-5FB5-312BDC7CF358"),
  (19,"Gary","Watts","719-352 Dignissim Rd.","Auburn","Australia","111-6402","lacus.cras@hotmail.edu","2461FC83-7A77-0046-1874-34FD048AC1D1"),
  (20,"Melissa","Guzman","P.O. Box 165, 9394 Ante. St.","Cusco","Norway","671-5512","donec.egestas@google.couk","2B272DB5-9D89-7D45-1D7E-97AC5891116E"),
  (21,"Lester","Mullins","192-8041 Placerat, Ave","Flekkefjord","Vietnam","1-561-478-1611","cum.sociis@icloud.org","5EC8E9B2-22CF-190A-BC09-7E7125ECD722"),
  (22,"David","Noel","Ap #706-9538 Per Ave","Bergen","Russian Federation","612-4293","convallis.erat@google.ca","EC712466-12F3-2C51-1F9A-8CF76EECC92D"),
  (23,"Galvin","Houston","Ap #200-7585 Ipsum. Av.","Yên Thịnh","Germany","1-977-272-2318","mollis.phasellus@yahoo.edu","DB32537C-8009-BF44-5E05-47E4E297387B"),
  (24,"Steel","Mcgowan","416-9540 Fringilla, Avenue","Berlin","Turkey","1-129-962-8802","faucibus.orci@hotmail.net","B429577A-B5BC-CF18-8B20-AE933E8D3A21"),
  (25,"Madeline","Hall","Ap #214-6331 Odio. St.","Straits View","Ireland","462-7141","at.pede@icloud.org","28ECA21C-43ED-EB32-9D42-A7B26193A6FB"),
  (26,"Garrison","Benton","Ap #681-7035 Gravida Avenue","Retie","Costa Rica","585-8731","at.sem@icloud.couk","368D55A3-CF84-94D9-62D7-018C4853E7BD"),
  (27,"Emi","Rocha","Ap #933-5468 Risus. Road","Cabadbaran","Netherlands","1-968-681-2623","curabitur.vel.lectus@yahoo.net","A1B20DC5-9E55-D229-13E9-FA12932C9387"),
  (28,"Candice","Hansen","P.O. Box 549, 790 Ultrices Avenue","Vinh","Peru","1-217-776-8495","nonummy@google.ca","1B332A92-4A74-62B1-A5B7-5CD0C9CD59B5"),
  (29,"Dennis","Kramer","Ap #789-9063 Magna St.","Gijón","Nigeria","1-408-544-4516","augue@hotmail.net","63512321-6721-6C32-594F-6588C059B28C"),
  (30,"Donna","Cohen","272-4527 Aenean Ave","Borås","Chile","1-452-345-8465","lacus.pede@aol.ca","2563BDDF-1267-B86B-3590-002DD245A5B5"),
  (31,"Flynn","Pate","421-3150 Sit Street","Volda","Indonesia","702-6223","mi.ac@yahoo.couk","7AE13876-A3BB-D8A1-51E3-A045A694AA1B"),
  (32,"Alan","Valencia","Ap #361-1618 Ipsum Avenue","Boon Lay","Italy","946-8556","tellus@hotmail.ca","D26E43AC-34ED-4361-20AF-789ED5A3A6AE"),
  (33,"Adria","Becker","Ap #134-6947 Vitae Av.","Winterswijk","Sweden","1-484-368-0886","lectus.sit@yahoo.couk","257EA747-512D-E5EF-4FE6-641C0E3C4284"),
  (34,"Elizabeth","Bernard","546-6757 Elit Street","Huế","South Africa","689-5193","est.mauris.eu@aol.com","28D63F1B-20A8-823E-6B59-9A5BAE8CCBE1"),
  (35,"Logan","Crawford","437-9305 Auctor Rd.","Tierra Amarilla","Poland","248-9907","pellentesque.tellus@yahoo.net","BB9A918C-9419-4126-828B-DE95560B8312"),
  (36,"Martin","Garza","Ap #372-2634 Mi Ave","Dublin","Norway","410-7550","orci.donec.nibh@protonmail.net","8D149685-F307-FABD-02A5-F697B3057259"),
  (37,"Macon","Cooper","116-6178 Proin Av.","Cholet","Costa Rica","1-185-272-4876","placerat.velit@outlook.edu","A3F23163-BEFD-C8A9-D43B-37FA81D2CD9E"),
  (38,"Karyn","Moody","589-768 Mi Street","Guápiles","Brazil","574-3476","pede@icloud.edu","013B6EF2-DBB6-F3DE-5E4C-660ECCE61871"),
  (39,"Debra","Dennis","435-9317 Gravida. St.","Chungju","Spain","715-2577","eu.tellus@icloud.net","1DE7812C-8D19-5571-AAC5-9573960D26ED"),
  (40,"Stephanie","O'donnell","368-7876 Sollicitudin Av.","Clementi","Australia","128-2119","vulputate.mauris@outlook.ca","78E29460-0C73-8D8C-D372-89868D3398A8"),
  (41,"Howard","Bruce","Ap #878-3972 Tincidunt, Street","Warri","South Korea","1-567-631-3089","diam.at.pretium@protonmail.com","E3599381-1560-FC19-54CC-DEB65EA4B961"),
  (42,"Larissa","Burke","Ap #841-4745 Metus. Av.","Heidelberg","Indonesia","1-701-888-7807","hendrerit.consectetuer.cursus@yahoo.couk","CBE9370B-38C4-29FC-7322-B8D13841228B"),
  (43,"Price","Underwood","Ap #671-7077 Aenean Av.","Shostka","Ukraine","1-934-574-7915","eget.varius@outlook.com","D89AE095-A5C9-1C1F-EBD8-DD769D10ECDD"),
  (44,"Phillip","Ware","Ap #798-3804 Id, St.","Constantia","India","1-867-926-2675","eu.erat@google.org","48D2215E-F86B-0C8F-37CD-A9DE872149A3"),
  (45,"Eve","Ware","P.O. Box 659, 8926 Risus. St.","Tarsus","Germany","544-1265","in@yahoo.edu","212F5C80-BCE9-401C-FA2B-39A6FCF13790"),
  (46,"Aileen","Snow","Ap #742-2581 Penatibus Rd.","Lidingo","Colombia","601-5655","metus.eu@yahoo.net","F9ECBC14-A293-47EC-B231-1E3E71247818"),
  (47,"Benedict","Leonard","852-6874 Ultrices St.","Białystok","Nigeria","653-9411","facilisis@outlook.com","A44BDA58-70C8-F6EE-A73B-ABA12AFB8315"),
  (48,"Ali","Figueroa","952-8906 Ante Av.","Whakatane","Russian Federation","704-0058","dictum@aol.net","85CF364D-C625-8C28-6677-D5DE6249DBBD"),
  (49,"Portia","Newman","Ap #991-8235 Nisi Rd.","Huntly","Colombia","1-578-706-5698","cum.sociis@aol.couk","977567D1-3F1A-AC02-3A65-D5D73D5592E5"),
  (50,"Nash","Cabrera","Ap #356-7683 Sapien, Rd.","Pukekohe","South Korea","1-756-766-1315","sed.malesuada@outlook.net","93BC0C8C-CAB5-E648-A3CE-01D253841B31"),
  (51,"Hayfa","Carney","370-9648 Integer Rd.","Zwettl-Niederösterreich","Canada","1-314-576-5336","est.ac.facilisis@yahoo.ca","D794321C-6158-E1C7-1CD4-C415B195AD7A"),
  (52,"Denton","Holland","Ap #462-9802 Et, Rd.","Tharparkar","United Kingdom","1-452-782-5811","aenean.eget@hotmail.net","D13F4A6E-8DA1-A9A6-AAAE-4952A61BF3E8"),
  (53,"Charles","Burt","642-9085 Nisl. Rd.","El Salvador","Poland","913-1622","pretium.aliquet@outlook.com","D4CE98E9-01C2-94CB-DE2F-D7745C55B2CB"),
  (54,"Barclay","Chan","Ap #817-1370 Nulla Avenue","St. Petersburg","Norway","852-1844","at@google.org","225970E9-7DEC-6B5C-8746-59824A39BA28"),
  (55,"Asher","Nichols","1523 Mi, St.","Hassan","Norway","131-0956","donec.vitae@aol.org","9A4DB621-9645-242C-A265-9912BB73BD8D"),
  (56,"Rinah","Gentry","725-6904 Convallis Avenue","Sankt Johann im Pongau","Germany","1-755-378-9248","neque.sed.eget@hotmail.com","AB3A23DD-53C8-E46A-E1AD-EE89C6511A2D"),
  (57,"Whoopi","Burch","993-2182 Tincidunt, Av.","Mojokerto","Pakistan","233-1385","mus.proin@aol.net","5462328B-B32C-3C46-4B1C-2CED731D98B6"),
  (58,"Ingrid","Ortiz","Ap #718-2180 Cras St.","Gölcük","Canada","775-5990","orci@google.org","12D04A36-9589-3D53-15A6-CE4D407CF6E7"),
  (59,"Talon","Berger","340-4969 Donec Av.","Pavlohrad","South Korea","1-514-308-1613","rutrum@outlook.org","236A948E-C359-F1F8-CA55-D9B0C558E439"),
  (60,"Barry","Aguilar","8458 Velit Street","Monguelfo-Tesido/Welsberg-Taisten","Chile","958-5851","ligula.aliquam@google.net","06AFD57B-AEEA-2879-15C3-7E3A905BA4E3"),
  (61,"Samson","Mack","406-265 Gravida. Av.","Cork","Ireland","690-6579","nulla@aol.com","C524EEBD-A650-E5A4-F8AA-3692CBCE3FDB"),
  (62,"Ashely","Hampton","P.O. Box 167, 4458 Metus. Street","Rves","United States","276-8695","velit.justo@outlook.couk","F6D8B615-F376-5D96-A6CF-5AD58A4C2BB2"),
  (63,"Maxine","Luna","Ap #704-458 Cras Ave","Almere","Singapore","1-968-355-7946","nonummy.ultricies@icloud.org","19F289A8-DFDB-41E2-5D4B-B676D93E8E50"),
  (64,"Colton","Hobbs","750-6328 Mauris Road","Cedar Rapids","Colombia","1-213-677-6175","vel.quam@aol.net","DD33D318-7803-BFD2-9C7F-8C648955EE9D"),
  (65,"Nolan","Rocha","Ap #391-4182 Dolor, St.","Zielona Góra","Colombia","796-9641","dictum.cursus.nunc@hotmail.couk","288EEDAB-57DA-4FA2-2027-BEFE88E154C6"),
  (66,"Christopher","Caldwell","P.O. Box 907, 2614 Vivamus Street","Beijing","Chile","707-8719","ultrices.posuere@hotmail.edu","11E4916D-1890-745E-97B3-07F162761771"),
  (67,"Erasmus","Mcclure","945-8711 Egestas. Street","Ila","Canada","286-2238","nunc@google.org","DD0C8E92-05B5-6DA2-D29C-0D6DB1E912EA"),
  (68,"Kaitlin","Vega","7310 Sit Ave","Skardu","Ireland","1-713-244-2255","nibh@protonmail.net","1A449D05-083A-BDBF-B866-77335670983C"),
  (69,"Linus","Bolton","P.O. Box 820, 3247 Auctor, St.","Salihli","Colombia","1-172-701-3534","cras.pellentesque@outlook.com","3C837348-E8D9-649E-B19E-2451E4AE928C"),
  (70,"Emmanuel","Rice","Ap #111-7216 Tellus Avenue","Ibagué","Ukraine","1-891-444-5855","vitae@google.org","ED5A1A59-28CB-566C-BD35-722AAD9CC873"),
  (71,"Alexander","Dorsey","Ap #595-4733 Suspendisse Avenue","Hudiksvall","South Africa","1-281-165-3432","non.vestibulum.nec@icloud.com","DBD1FBC3-E20A-1C15-AE3C-3986DAD3B8F5"),
  (72,"Emi","Cooke","286-5173 Orci, Rd.","Outram","Canada","1-389-441-1077","aliquet.lobortis@protonmail.edu","54640748-BCC9-D613-EE14-82896B4D3866"),
  (73,"Hamilton","Ruiz","Ap #443-9067 Congue, Avenue","Outram","Peru","437-8111","sit.amet@outlook.ca","A363C439-4448-4AD3-D185-A3433C373776"),
  (74,"Timothy","Newton","108-9524 Eu St.","Srinagar","Nigeria","847-3212","et@outlook.edu","4F4B7128-02E7-01D1-D7BD-7D922A8B5C19"),
  (75,"Lana","Santiago","391-6629 Pellentesque. Rd.","Bremerhaven","Ukraine","344-9560","hendrerit.donec@hotmail.org","AC4C6468-B6D2-77A9-731C-34FA9665D3C9"),
  (76,"Wing","Bentley","P.O. Box 188, 9660 Neque St.","Guaymas","Costa Rica","718-7678","velit.egestas.lacinia@yahoo.couk","4FF72457-1F45-C9EE-D66B-1B2478D9DAD7"),
  (77,"Clementine","Shaw","Ap #746-7230 Elementum Road","Weißenfels","United States","763-5237","id.risus@yahoo.org","5A887B03-5B7A-3E95-4BF8-22798E86E33B"),
  (78,"Brenden","Sexton","Ap #857-8428 Amet, Av.","Bathurst","Spain","1-198-215-5476","metus.in@aol.couk","94776C76-1D28-D9CC-896A-9D9D6092C31D"),
  (79,"Philip","Fry","P.O. Box 238, 5572 Ut St.","Tuguegarao","Nigeria","1-687-712-7281","imperdiet@icloud.couk","5C7A7835-75B7-3220-8A92-FD8ECD47FDEE"),
  (80,"Amaya","Butler","8086 Eu, Av.","Ørsta","South Africa","1-354-416-8053","arcu.vel.quam@icloud.couk","516D3CAB-ED02-98EE-D3E8-5E5935512492"),
  (81,"Keegan","Terry","524-3768 Nec, Road","El Tabo","Turkey","234-2542","tellus.lorem@aol.com","D85D5231-ABD5-1E96-A237-E5D545E666D3"),
  (82,"Cooper","Barron","5904 Lectus Rd.","Gijón","Peru","416-9365","nunc.lectus@yahoo.net","61961032-293B-7470-2E9D-FD60654ADE0C"),
  (83,"Malachi","Collins","Ap #488-9914 Eget Rd.","Tarnów","Australia","910-1775","iaculis@icloud.org","499360C7-3CD8-2C31-9AF7-5A98EEE4E568"),
  (84,"Hop","Rollins","155-6016 Tincidunt Rd.","Fort Resolution","Singapore","211-2596","nisl@google.net","377179B4-B1BF-DC25-39C9-16C12EEE7578"),
  (85,"Ignacia","Crosby","Ap #902-3940 Erat St.","Taupo","Brazil","1-721-591-3281","tortor.dictum.eu@hotmail.ca","5D1AE23E-F51E-525C-8389-E71AE4FD2496"),
  (86,"Murphy","Compton","Ap #443-4062 Nibh Street","Bellville","Ukraine","1-272-884-0374","vulputate.ullamcorper.magna@google.org","FBACA49E-FA47-0571-26D7-C294B5E33C76"),
  (87,"Wyoming","Sims","632-9413 Nec, Rd.","Palmerston","Peru","1-443-501-1711","cursus@aol.ca","68961C5C-E92F-5526-B06C-3BAAC2DFE968"),
  (88,"Evelyn","Browning","504-8539 Suspendisse St.","Gapan","New Zealand","1-733-748-6354","lacus.cras@aol.couk","330A5799-B3B1-B7BF-3A71-10718C852AE4"),
  (89,"Amal","Chan","347-3422 Malesuada Road","Cork","Germany","1-883-519-1556","orci.phasellus@hotmail.couk","1C2E8186-3318-E1F1-EC2A-A982BD0D5B5C"),
  (90,"Gabriel","Macdonald","151-5734 Auctor, Avenue","Rotterdam","Ukraine","266-1156","tincidunt@icloud.edu","A3D2BC58-D588-CC1C-093C-22C40613CEB0"),
  (91,"Wylie","Alford","Ap #586-562 Sagittis Ave","Novena","France","608-2541","sit.amet@protonmail.net","CEFA7BB5-E896-8C52-91A7-E7C67E47EC24"),
  (92,"Sierra","Goff","4398 Lacus. Avenue","Göteborg","Ireland","522-7431","tempor.arcu@yahoo.ca","3206773C-DE89-F615-4726-A1886716879A"),
  (93,"Fiona","Lindsey","963-4846 Non, St.","Ulyanovsk","South Africa","267-1274","quam.vel@google.net","A9CCC31B-BAE6-54EA-E619-A69115C5187C"),
  (94,"Rhoda","Sparks","217-4378 Diam Ave","Guangxi","Nigeria","1-936-573-3561","sollicitudin.adipiscing@protonmail.org","C3EEC33A-88E4-87B8-185A-652282EB33C3"),
  (95,"Hedy","Dillard","P.O. Box 230, 2851 Suspendisse St.","Port Nolloth","Poland","1-464-148-8489","dui.in@icloud.net","D5987996-74F5-FCA6-975D-9C3B4D55DA05"),
  (96,"Ishmael","Johnson","509 Magna. St.","Yunnan","Mexico","1-935-537-1961","ornare.facilisis@protonmail.couk","A14E7EC4-5E79-A091-4BB5-CE52FCF4FCE5"),
  (97,"Roth","Craig","Ap #602-2055 Cras Road","Medemblik","Brazil","295-5168","vehicula.risus@protonmail.couk","1BB6E647-9EE5-4D58-D7E9-AC1CBD333A5E"),
  (98,"Julie","Franklin","149-8011 Eros Avenue","Sosnowiec","Italy","226-5128","nulla.vulputate@hotmail.ca","57875D1A-224B-4AD1-91A1-17ABD65C4879"),
  (99,"Lucian","Kerr","630-5993 Pede St.","Sosnowiec","New Zealand","1-516-356-0727","sed.consequat.auctor@icloud.edu","4E5A1F58-205B-689A-643E-B4CE609CE0E8"),
  (100,"Idola","Hobbs","295-8522 Lacinia Road","Medio Atrato","Austria","390-0114","aenean@outlook.net","E934C534-7597-1D53-6B22-A18706E1E795"),
  (101,"Asher","Pacheco","P.O. Box 347, 4608 In Road","Kupang","Austria","916-4404","pede.nonummy@protonmail.couk","9221E938-DC08-779A-4B72-43936FE58F04"),
  (102,"Matthew","Cabrera","1873 Metus. Road","Izium","Russian Federation","1-322-513-9386","libero.donec@outlook.edu","A98079A1-3E8B-3E45-E981-B99A21A949EC"),
  (103,"Ishmael","Lara","320-3488 Ultrices. St.","Hofors","South Korea","1-356-411-0522","dui.suspendisse.ac@icloud.couk","59EDD484-5767-C797-48B0-3E58B78D7639"),
  (104,"Griffin","Holmes","648-229 Dictum Rd.","Tonalá","Pakistan","1-301-451-6163","mauris.morbi@hotmail.com","ED9432AA-6C26-2DA5-5113-DE13A8C8F872"),
  (105,"Yoshio","Hood","Ap #197-6342 Cum Rd.","Crato","Brazil","1-283-222-6315","mi.duis@aol.org","BA4FA195-54FC-71CC-07C7-EA2737B827E2"),
  (106,"Kamal","Hansen","P.O. Box 596, 445 Amet Av.","Tranås","Austria","810-2764","velit.justo@outlook.org","3B591C0E-E693-99C8-97F2-2848DB246C3A"),
  (107,"Harding","Murphy","846-9005 Nulla. Road","Port Augusta","South Africa","1-540-254-4190","hendrerit.id@yahoo.org","D4526C24-5191-2FA3-1535-1A5ACB391DF1"),
  (108,"Maite","Valentine","916-546 Diam Rd.","Tczew","Colombia","1-582-170-8869","nunc.sed@icloud.couk","7C313684-163C-1795-82A9-749AE635292B"),
  (109,"Lunea","Dudley","606 Libero Rd.","Lào Cai","Austria","1-177-333-9984","orci.adipiscing@protonmail.couk","83E7E6B8-76ED-E72E-F551-799D9E829DA5"),
  (110,"Octavius","Hogan","Ap #116-4310 Nibh. Street","Ulm","Costa Rica","513-9841","integer.tincidunt@icloud.ca","9C27C8A9-469A-E55C-4143-727A58CC7D26"),
  (111,"Levi","Burke","Ap #362-8153 Enim St.","Sankt Johann im Pongau","Spain","978-3188","quisque@protonmail.com","C36D5788-59AD-D914-1B36-3399A35BB934"),
  (112,"Quin","Armstrong","7532 Et Ave","San Juan de Girón","Netherlands","568-1428","risus@outlook.couk","CE11BBD2-8412-2FEE-11C6-DD34B2B525CE"),
  (113,"Florence","Sanchez","Ap #149-4958 Scelerisque St.","Ełk","Ukraine","1-522-357-7244","blandit@protonmail.ca","DD6A24C7-38F9-8C51-D50E-BE492EA4A2F4"),
  (114,"Alika","Hays","6264 Integer Street","Lambayeque","Spain","273-4000","dignissim.tempor@outlook.com","243C1E13-6FE1-7134-C129-E1133399F99C"),
  (115,"Calista","Nguyen","Ap #485-2015 At Rd.","Gijón","United Kingdom","1-982-384-7190","ut.semper@protonmail.edu","A88B8C70-3F95-E1BA-883C-D8C1339ED983"),
  (116,"Stewart","Pickett","Ap #638-2873 Accumsan Ave","Gatchina","New Zealand","1-394-966-5854","augue@yahoo.org","633CC967-72C1-F422-DB82-0DF9845FBD69"),
  (117,"Angelica","Mcdowell","314-6551 Suspendisse Ave","Regensburg","China","107-8736","interdum.curabitur@yahoo.edu","AE71BCA4-B75E-4174-40DB-11F258ED86BC"),
  (118,"Brent","Rodriquez","6490 Cras St.","Anápolis","Singapore","703-4689","dolor.sit@hotmail.org","714BE063-7CE6-EE69-21E1-6861AE1DC98F"),
  (119,"Jasper","Leblanc","P.O. Box 200, 2197 Lacus. Street","Canoas","United Kingdom","821-4412","scelerisque.sed@hotmail.org","C3AA725D-0CE3-3F78-128A-FC544A9A172D"),
  (120,"Rosalyn","Ware","244-9874 Aliquet Rd.","Fogo","Philippines","925-5318","nunc.quisque.ornare@outlook.edu","90C73322-23B0-A8E0-C932-D839AEE1452F"),
  (121,"Martin","Valentine","Ap #273-5629 Risus. Avenue","Ciudad Victoria","Ukraine","1-601-375-1188","aliquet.nec@icloud.org","A430B078-DE0D-6C1B-A944-33F7E3C33787"),
  (122,"Ross","Best","609-1366 Eget St.","Jeongeup","Turkey","1-882-740-9575","dui.lectus@yahoo.org","BBC39917-D1D7-529E-C651-35C3E4C46DA3"),
  (123,"Ruby","Chapman","966-5553 Hendrerit St.","Đồng Xoài","Peru","237-1131","hendrerit@icloud.com","2ED99A5E-8DC8-26B7-6489-891D9232C4D8"),
  (124,"Yoshio","Klein","P.O. Box 997, 972 Adipiscing Rd.","Simpang","Indonesia","483-8942","lorem.sit.amet@protonmail.com","A40EE8B4-2BAB-2D72-DDC5-40E9AD4FBCCD"),
  (125,"Nola","Morris","7275 Semper St.","San Isidro","South Africa","463-3834","at.fringilla@google.net","7AEBDB6A-0765-910E-1469-34A3CB7A6646"),
  (126,"Ila","Mccormick","519-8867 Vel St.","Pontianak","United States","1-650-635-0443","et.netus@hotmail.com","1ABB1099-6631-D9C1-01FD-ECA4CF558466"),
  (127,"Candice","Dixon","348-1951 Lacus. Road","Huancayo","United Kingdom","554-6768","montes@outlook.couk","76818443-5083-CA25-205B-A0AD4E26C3F8"),
  (128,"Robert","Pearson","P.O. Box 596, 2508 Id, Rd.","Daegu","Chile","468-8011","nonummy.ultricies@hotmail.ca","8E3DBA17-C5CB-F234-94AE-32B0E4BA181C"),
  (129,"Remedios","Bright","Ap #398-4143 Eu Road","Puno","New Zealand","345-5487","conubia.nostra@google.org","128A1933-418C-D1B3-D765-5BCEF69E5327"),
  (130,"Nolan","Banks","Ap #197-5995 Nunc Road","Ciudad Valles","Singapore","1-266-516-7392","nascetur@yahoo.ca","D3906C07-AB32-E199-ED05-9AEE25C9D4AE"),
  (131,"Whilemina","Cotton","8991 Rhoncus Avenue","Meerut","Ukraine","1-284-636-4463","orci.consectetuer@icloud.couk","42FC4B54-7772-B3D3-C5F2-9AC2F5571BEE"),
  (132,"Damian","Henson","460-3552 Pede Avenue","Gjoa Haven","South Korea","362-8331","vehicula@protonmail.org","517EF454-D163-65EA-D7BE-C4A92AE6E135"),
  (133,"Piper","Webster","P.O. Box 555, 3296 Nec Street","Kemerovo","Belgium","659-2148","aliquam.tincidunt@hotmail.net","9347C8B4-E8BD-9367-3A20-41391E76A9B7"),
  (134,"Russell","Terrell","Ap #824-7917 In Road","Charlottetown","Singapore","843-8518","vel.turpis.aliquam@google.edu","BAA6F8D7-89A8-86FD-74A3-1B6CD3558242"),
  (135,"Calista","Crawford","2810 Et Road","Mödling","Ireland","234-6342","nulla@protonmail.ca","FFC47832-3198-9BEC-30A8-7106CE95FA9E"),
  (136,"Allen","Noble","P.O. Box 604, 4581 Dictum Road","Arequipa","Ukraine","1-985-565-8853","eget@outlook.com","16DC0A69-43B1-C7D4-B10D-1B2600CB8D13"),
  (137,"Leroy","Jenkins","1000 Augue Road","Oaxaca","United Kingdom","1-414-247-8412","consectetuer.mauris@google.net","A37646C2-2EAB-3D65-2138-47F2311FC20D"),
  (138,"Tanya","Montoya","706-4993 Laoreet Street","Saint-Étienne-du-Rouvray","Italy","874-9680","cras.interdum@protonmail.net","5C4E69D9-020B-3E9A-3D39-2B961762170A"),
  (139,"Deirdre","Norton","255-4050 Ut Av.","Dublin","France","1-624-167-2944","lacinia.at@hotmail.org","9E90A6D4-2A08-D094-AEA5-FAD87465C294"),
  (140,"Grant","Johnson","Ap #600-519 Luctus Av.","Liberia","United States","1-488-675-1683","ligula@yahoo.couk","8848992A-E550-BBE9-6515-1FAE3B91847B"),
  (141,"Camille","Montgomery","Ap #662-6892 Sit St.","Medan","Ukraine","1-425-954-4623","fusce.feugiat@yahoo.com","E5AA204A-1A05-8A4D-ED09-97A6A475E85F"),
  (142,"Charissa","Byrd","Ap #689-4399 A Rd.","Gönen","France","1-781-922-2615","eu.neque@yahoo.couk","EDFDEBFE-5C54-C407-AD5B-4C33DE2AA765"),
  (143,"Len","Rodriguez","918-3642 Sed Ave","Kristiansund","Ukraine","322-8952","sapien.cursus@outlook.edu","7B72838D-674E-E51E-3947-9423DD8985F3"),
  (144,"Macaulay","Jenkins","Ap #682-6389 Rutrum Av.","Icheon","Spain","1-788-384-8480","nisi.cum.sociis@protonmail.org","DB99F107-B375-12C6-E332-79D1CB844467"),
  (145,"Gail","Mendez","3065 Nam Rd.","Thủ Dầu Một","Austria","998-7178","eros@aol.couk","BA77D2C6-2E9A-BC4E-6EC6-E3EB97A4C4D2"),
  (146,"Stone","Leonard","7140 Pellentesque Av.","Tver","New Zealand","898-3576","eu.ultrices@icloud.net","ADF8C683-A360-AB16-95DD-B434484D2E00"),
  (147,"Tashya","Maynard","430-1944 Feugiat. Rd.","Konya","Ireland","366-3841","bibendum@protonmail.couk","5A494108-9627-D35A-A8DD-9D16231DA382"),
  (148,"Harrison","Puckett","438-1426 Hendrerit Rd.","Tocopilla","Pakistan","1-206-271-8024","arcu.eu.odio@outlook.edu","58735C98-A913-EAB8-9AAD-3218F4C6F5ED"),
  (149,"Charles","Carter","Ap #295-847 Massa Road","Istanbul","Vietnam","920-3808","mattis@aol.org","D5E11CC8-6364-DA1A-882C-9DC25B113954"),
  (150,"Pascale","Morton","830-3115 Aliquam Rd.","Alnwick","Ukraine","596-7410","nam@icloud.net","C0CADC7D-84CD-262A-152D-52911368707D"),
  (151,"Christian","Orr","663-8036 Natoque Road","Seattle","New Zealand","947-6316","ac.sem.ut@protonmail.org","A7B7B2F0-BB8D-AA2C-B9A2-58EA1D3B923E"),
  (152,"Dane","Lambert","P.O. Box 980, 6149 Sed, Street","Ránquil","Pakistan","1-970-371-3624","aliquam@icloud.org","22680A7E-2011-32D6-4F39-5F11D946E0B7"),
  (153,"Abigail","Barnes","460-8918 Elementum, Rd.","Port Augusta","Colombia","1-428-338-2637","eget.magna.suspendisse@google.ca","3E4DED5B-F5DC-F5C0-2AAF-8A88F2865725"),
  (154,"Martena","Charles","P.O. Box 107, 4335 Turpis Avenue","Imphal","India","112-2061","adipiscing.mauris@icloud.couk","D832F47A-38EE-7E7D-298A-7C02D3F64CCD"),
  (155,"Carly","Tran","P.O. Box 867, 3465 Accumsan Rd.","Hamburg","Costa Rica","1-316-337-4511","amet.luctus.vulputate@outlook.ca","47B9D448-C5BC-A8A9-B1B7-6358C85E54EE"),
  (156,"Wyatt","Jarvis","Ap #709-2804 Scelerisque Av.","San Pablo","India","1-880-350-4453","phasellus.vitae@aol.edu","C4CCD02D-48C3-6ED7-88F3-6D26CE79EA1B"),
  (157,"Keely","Mack","1522 Pellentesque Rd.","Hudiksvall","Norway","1-674-461-4585","neque.sed@hotmail.net","5AC5D335-DACA-1771-3360-E2A8A806452A"),
  (158,"Melyssa","Vaughan","P.O. Box 589, 5857 A Road","Chungju","New Zealand","1-578-877-3406","dolor.dapibus@hotmail.com","0274CB97-65EC-CBB7-3BDD-651A494797E9"),
  (159,"Chancellor","Walls","341-4465 Et Av.","Killa Saifullah","Turkey","1-823-748-8273","id.ante@protonmail.org","21DED329-73A8-4FC8-F9F5-658DB8CEC239"),
  (160,"Gray","Fisher","7241 Ligula Rd.","Ollolai","Canada","368-7804","vulputate@outlook.edu","9B57B921-62AE-989F-EEB5-8163198E42BB"),
  (161,"Cherokee","Mckay","434-876 Eu St.","Villahermosa","Chile","1-724-477-6833","sollicitudin.orci@google.net","A8FC0048-4B5E-CDB7-4C78-4F832D46E4E9"),
  (162,"Tanner","Phelps","463-2032 Vel Av.","Fourbechies","Canada","175-7556","lacinia.at@outlook.org","30D7A8A4-1052-3EE4-7FCB-979088590AD7"),
  (163,"Yen","Wells","2686 Quam Rd.","Monte Patria","Indonesia","186-5652","pellentesque.habitant.morbi@hotmail.net","AA8EED91-C1CC-6A3E-79DB-B1E9DD2DDC34"),
  (164,"Zenia","Collier","567-6134 Suspendisse Rd.","Corozal","Poland","1-457-504-2523","ridiculus@google.couk","AA0C27AD-5D3B-DE99-2B19-D4A107794257"),
  (165,"Robin","Ballard","Ap #467-6698 Natoque Rd.","Recogne","United Kingdom","1-642-295-3265","vivamus.sit@protonmail.com","FD6AFE08-5C68-C43D-E879-47395D1E96E8"),
  (166,"Quinlan","Perez","8543 Neque Ave","Bama","China","434-7236","nam.nulla@hotmail.ca","41E7D3F4-B9E5-88F8-5A44-88929998502B"),
  (167,"Kelly","Ramos","Ap #712-685 At Road","Moulins","Spain","1-867-541-6572","malesuada@yahoo.net","0EFAE5D6-0260-8CEE-995E-43AF69886A6E"),
  (168,"Cecilia","Carver","3204 Enim Rd.","Belfast","Poland","1-632-347-1726","donec.sollicitudin@hotmail.com","B49B9E8D-B3C2-AA7B-0239-64B23115E473"),
  (169,"Cameran","Howe","4317 Adipiscing, Rd.","Khmelnytskyi","United Kingdom","325-6096","donec.egestas@protonmail.couk","11192865-1AC3-8399-9CAD-76A9D747AF3E"),
  (170,"Martha","Sims","618-9903 A Ave","Santa Cruz de Tenerife","Ireland","1-562-948-1608","vestibulum@hotmail.com","6CE4B791-88D1-3739-992C-13CE6E809AE8"),
  (171,"Gillian","Odom","Ap #164-4368 Ante Rd.","Assen","Chile","1-552-336-6079","elit.aliquam@protonmail.ca","7FBBA445-8541-2974-F21E-EDD9B72D1886"),
  (172,"Carissa","Rivera","4264 Vestibulum. St.","Mersin","Australia","539-0186","aenean.eget@protonmail.edu","D416A868-A979-DAE3-5497-D717166DAA63"),
  (173,"Odysseus","Weiss","737-632 Adipiscing Rd.","Workum","Pakistan","1-740-527-6635","diam@icloud.ca","9CE78E5F-4AD1-4AC5-B1B1-893D9BA0B264"),
  (174,"Penelope","Workman","Ap #385-683 Curabitur Street","Khmelnytskyi","Poland","579-7053","ut.aliquam.iaculis@outlook.com","92F3C77E-41CC-504B-C1AB-2B343D19802B"),
  (175,"Vernon","Torres","167-5825 In Rd.","Avesta","Brazil","987-2927","ipsum@outlook.net","BF5321D6-923B-A669-F042-0BE473411ACC"),
  (176,"Cynthia","Pena","Ap #199-7359 Egestas. Street","Paine","United Kingdom","348-6554","risus.nulla.eget@yahoo.net","BE827AB4-5DDE-64DD-DBBA-86945113CDFF"),
  (177,"Ivana","Hyde","Ap #185-7776 Vitae Road","Pietermaritzburg","Belgium","1-434-455-8354","dolor@protonmail.com","8E81D04F-D14D-1E0D-7361-416E7B7B21DE"),
  (178,"Wilma","Lucas","Ap #827-1127 Vestibulum, Rd.","Ede","South Africa","1-356-335-4285","adipiscing.non@yahoo.ca","A635565F-3D9B-41CA-4E2A-D9EEC74D7E31"),
  (179,"Berk","Mcintosh","Ap #955-6963 Vulputate, St.","Acacías","Canada","316-9424","facilisis.suspendisse@hotmail.com","110742D8-2EB9-DEE9-393D-26AA6E2D9BA9"),
  (180,"Jarrod","Heath","839-4059 Ultrices. Road","Santa Rita","Australia","1-288-686-2574","sem.eget@google.edu","1BE691B2-D185-4A7C-C2D3-56254D4AB071"),
  (181,"Madeline","Alvarado","920-3303 Et Avenue","Piura","South Korea","1-154-138-5727","vestibulum.accumsan.neque@yahoo.ca","ACF9E746-9AD8-D846-38CA-053C8760B608"),
  (182,"Ora","Rogers","686-9927 Pellentesque Street","Rathenow","Australia","821-4568","elit@aol.net","A6473D97-CC01-7BA9-3E84-6CA88571D42A"),
  (183,"Chaney","Curtis","478-8196 Nec, Av.","Frankston","Mexico","143-3123","cubilia.curae.donec@aol.com","E84FAFB5-3838-761D-F522-B562C38C8AD2"),
  (184,"Flavia","Byrd","442-9496 Ultricies Rd.","Nha Trang","Turkey","1-805-514-6663","ac@aol.org","48E68997-F132-AF12-D531-B2D495717D65"),
  (185,"Emi","Horne","547-5154 Sit Ave","Pskov","Sweden","1-515-686-5843","rutrum.fusce@hotmail.org","88A2BF73-44D2-7493-9723-BC75ADC9BC9A"),
  (186,"Roary","Tanner","Ap #521-8982 Egestas Ave","Bilaspur","Turkey","1-215-754-1756","elementum@yahoo.edu","A735EDA7-4DC5-9739-E719-6E2C8B5490F7"),
  (187,"Mechelle","Lester","Ap #445-5635 Quis St.","Rouvreux","Belgium","1-898-154-2157","cras@outlook.edu","0593AA39-5463-4A15-31C2-BA8871E43308"),
  (188,"Illiana","Smith","9817 Mi Road","Llaillay","Indonesia","438-1813","fringilla@protonmail.edu","721245D2-629E-C174-EF95-E7F059B36DC4"),
  (189,"Darrel","Blackburn","P.O. Box 754, 9938 Sed Avenue","Sembawang","Spain","1-207-917-2174","ipsum.donec@outlook.net","FEEE0F02-6A45-68AB-2E7E-9C824A5E4357"),
  (190,"Octavia","House","Ap #639-6703 Imperdiet, Street","Grahamstown","Australia","660-7528","interdum.ligula.eu@outlook.net","789B1854-0945-8C7F-1723-B34CBB5A720E"),
  (191,"Laura","Best","176-7998 Nulla Street","Tibet","South Africa","1-288-376-6405","fermentum@protonmail.edu","EEDDA931-7AC6-37BD-DE0A-69A078EA1496"),
  (192,"Ciara","Rodgers","499-8014 Venenatis Street","Hồ Chí Minh City","Austria","404-5286","blandit.congue.in@outlook.com","2CC4D13D-45B6-7A50-CAD9-48B9A2D181D0"),
  (193,"Jesse","Walton","984-5706 Egestas Street","Okene","Belgium","948-4548","sit.amet@icloud.com","87AC6219-6623-B672-2493-4BDB8760E41E"),
  (194,"Nissim","Noel","828-8470 Dictum Street","Kawerau","South Korea","653-4336","vitae@google.net","B7B79C5C-3797-BD69-44D3-DE687B9DE66F"),
  (195,"Owen","Barlow","9044 Vestibulum Av.","Thames","Russian Federation","1-778-771-6455","odio.vel.est@aol.edu","82AE83D5-4C49-62DB-6CD4-BA29184D2413"),
  (196,"Steel","Yates","8617 Et Street","San Pablo","Mexico","480-4643","elit.pretium.et@icloud.com","AA625343-7686-AA7D-3BFA-A5637558D301"),
  (197,"Alexis","Singleton","Ap #995-1860 Eu Road","Avesta","New Zealand","1-405-563-1226","molestie@yahoo.net","93CB5AE6-5E49-91E1-4E4D-6E5CBB74681B"),
  (198,"Ira","Pollard","Ap #774-8446 Erat, St.","Bathurst","Australia","778-1266","vel.est@google.couk","8CC9ECE9-AFDA-78D2-7ECE-201BBAD7BEB6"),
  (199,"Donna","Stafford","544-3228 Feugiat Street","Volgograd","Germany","1-663-446-1118","vestibulum@protonmail.net","1877837A-18A5-237A-0313-A7DD7B2835EA"),
  (200,"Melanie","Carver","Ap #922-8096 Blandit. Av.","Kramatorsk","Canada","687-1174","penatibus.et@outlook.com","D7ACCAC8-8695-E5D8-87DD-546DF7E2805B");


/* RESTAURANT*/
/*
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (1,"Esther's German Saloon ","11:30:00","22:30:00","german ","Ap #415-3372 Integer St.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (2,"Robatayaki Hachi ","17:30:00","23:30:00","japanese ","P.O. Box 934, 9196 Aliquam Avenue");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (3,"BBQ Tofu Paradise ","16:30:00","20:00:00","vegetarian ","P.O. Box 288, 7929 Arcu. Avenue");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (4,"Le Bateau Rouge ","17:00:00","23:30:00","french ","5004 Ante Ave");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (5,"Khartoum Khartoum ","11:00:00","14:00:00","african ","Ap #334-2573 Ut Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (6,"Sally's Diner ","8:30:00","20:00:00","american ","P.O. Box 680, 9002 Lobortis Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (8,"Saucy Piggy ","15:00:00","22:00:00","barbecue ","6912 Et Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (9,"Czech Point ","10:30:00","21:30:00","czech/slovak ","2013 Nulla Ave");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (10,"Der Speisewagen ","17:00:00","22:30:00","german ","776-1084 Urna St.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (11,"Beijing Express ","11:00:00","22:30:00","chinese ","Ap #720-156 Eget, St.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (12,"Satay Village ","17:30:00","22:00:00","thai ","877-6924 Tempus, Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (13,"Cancun ","11:30:00","23:00:00","mexican ","923-6779 Ullamcorper. Ave");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (14,"Curry Up ","17:00:00","22:00:00","indian ","Ap #868-7380 Sem St.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (15,"Carthage ","17:00:00","22:30:00","african ","Ap #193-7462 Purus Street");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (16,"Burgerama ","11:00:00","23:00:00","american ","P.O. Box 480, 2501 Odio, Road");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (17,"Three Little Pigs ","11:30:00","22:30:00","barbecue ","8768 Dolor Ave");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (18,"Little Prague ","11:00:00","22:00:00","czech/slovak ","Ap #103-1352 Diam Road");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (19,"Kohl Haus ","17:00:00","22:30:00","german ","2641 Nunc. St.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (20,"Dragon's Tail ","17:00:00","2:00:00","chinese ","4838 Vel, Av.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (21,"Hit Me Baby One More Thai ","15:00:00","22:00:00","thai ","P.O. Box 369, 1555 Elementum Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (22,"The Whole Tamale ","10:30:00","21:30:00","mexican ","147-2603 Tristique St.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (23,"Birmingham Bhangra ","17:00:00","22:30:00","indian ","Ap #546-1423 Nibh Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (24,"Taqueria ","11:00:00","22:30:00","mexican ","257-2021 Et Road");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (25,"Pedro's ","17:30:00","22:00:00","mexican ","Ap #454-5567 Felis, St.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (26,"Super Wonton Express ","11:30:00","23:00:00","chinese ","604-8283 Arcu Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (27,"Naan Sequitur ","17:00:00","22:00:00","indian ","879-4022 Tristique Street");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (28,"Sakura ","17:00:00","22:30:00","japanese ","355-350 Placerat, Road");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (29,"Shandong Lu ","17:00:00","22:30:00","chinese ","342-5579 Mauris Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (30,"Curry Galore ","11:00:00","22:30:00","indian ","6763 Fusce Street");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (31,"North by Northwest ","6:00:00","18:00:00","cafe ","7942 Suspendisse Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (32,"Full of Beans ","6:30:00","20:30:00","cafe ","Ap #779-4315 Lectus Road");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (33,"Tropical Jeeve's Cafe ","7:00:00","14:30:00","cafe ","975-7185 Lobortis. St.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (34,"Zardoz Cafe ","10:30:00","0:00:00","cafe ","Ap #899-6961 Curabitur St.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (35,"Angular Pizza ","6:00:00","0:00:00","pizza ","1692 Consequat Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (36,"Flavia ","11:30:00","22:00:00","pizza ","6678 Rhoncus. Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (37,"Luigi's House of Pies ","16:30:00","23:00:00","pizza ","532-6335 In Road");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (38,"Thick and Thin ","17:00:00","23:30:00","pizza ","Ap #149-7813 Et St.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (39,"When in Rome ","11:00:00","21:30:00","pizza ","735-5254 Dignissim. Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (40,"Pizza 76","10:30:00","22:00:00","pizza ","Ap #961-1208 Erat Ave");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (41,"Midtown Kabob House","11:30:00","44679,8958333333","fast ","633-8985 Nisl Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (42,"Papa’s Pizza & BBQ","17:30:00","22:30:00","fast","282-8538 Semper St.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (43,"Pekin Pavilion","16:30:00","23:30:00","fast","853-3413 In Ave");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (44,"Motor City Grill","17:00:00","20:00:00","fast","Ap #743-1598 Non, Ave");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (45,"Bakersfield Tacos","11:00:00","23:30:00","fast","P.O. Box 866, 394 Luctus Ave");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (46,"That Sandwich Place","8:30:00","14:00:00","fast","Ap #254-8100 In Road");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (47,"Little Caesars Pizza","15:00:00","20:00:00","mediterranean","P.O. Box 947, 1105 Feugiat Ave");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (48,"Subway","10:30:00","22:00:00","mediterranean","P.O. Box 828, 7470 Mi, Ave");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (49,"The Market District","17:00:00","21:30:00","mediterranean","Ap #436-7190 Nunc Av.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (51,"Little Caesars Pizza","11:00:00","22:30:00","mediterranean","Ap #457-2481 Odio Road");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (52,"Jet’s Pizza","17:30:00","22:30:00","mediterranean","830-6602 Diam Road");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (53,"AK Takeaway","11:30:00","22:00:00","mediterranean","120-1724 Pellentesque Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (55,"Detroit River Tour","17:00:00","23:00:00","mediterranean","461-2224 In Avenue");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (56,"China House","17:00:00","22:00:00","mediterranean","7065 Cras St.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (57,"Truth Music Cafe","11:00:00","22:30:00","american ","Ap #456-5372 At Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (58,"Bahn Thai Xpress","11:30:00","23:00:00","american ","Ap #951-4165 Sit Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (59,"McDonald’s","11:00:00","22:30:00","american ","Ap #759-2922 Tincidunt Ave");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (60,"Happy’s Pizza","17:00:00","22:00:00","american ","Ap #940-2478 Urna. Ave");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (61,"United Cafe Coney Island","17:00:00","22:30:00","american ","4852 Fringilla Road");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (62,"Le Petit Zinc","15:00:00","2:00:00","american ","Ap #577-1538 Tincidunt St.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (63,"Cafe Mix","10:30:00","22:00:00","american ","789-535 Amet, Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (64,"Sterling Services","17:00:00","21:30:00","american ","4114 Sodales Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (65,"Motown Cafe & Grill","11:00:00","22:30:00","american ","Ap #180-9154 Aliquam Street");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (66,"Legends Coney Island","17:30:00","22:30:00","german ","492-7646 Mauris, Street");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (67,"Chick-fil-A","11:30:00","22:00:00","japanese ","Ap #587-399 Egestas Road");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (68,"Wendy’s","17:00:00","23:00:00","vegetarian ","938-9777 Aliquet Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (69,"Marios Restaurant","17:00:00","22:00:00","french ","P.O. Box 208, 3213 Ante Av.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (70,"Peking Express","17:00:00","22:30:00","african ","Ap #723-6500 Nam St.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (71,"Ella Mae’s Place","11:00:00","22:30:00","american ","P.O. Box 356, 387 Non Road");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (72,"Subway","6:00:00","22:30:00","barbecue ","Ap #951-4527 Facilisis Road");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (73,"El Caporal Taqueria Y Restaurant","6:30:00","18:00:00","czech/slovak ","8085 Morbi Road");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (74,"Kabob N Grill","7:00:00","20:30:00","german ","Ap #263-657 Ultrices. Street");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (75,"The Breadstick Bar and Bistro","10:30:00","14:30:00","chinese ","616-2819 Massa Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (76,"Chick-fil-A","6:00:00","0:00:00","thai ","4094 Luctus St.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (77,"Subway","11:30:00","0:00:00","mexican ","Ap #480-9171 Orci, Av.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (79,"Delicious Dogs","16:30:00","22:00:00","indian ","Ap #555-2592 Parturient Ave");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (80,"Gratiot Grill","17:00:00","23:00:00","african ","976 Sed Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (81,"Little Caesar’s Pizza","11:00:00","23:30:00","american ","2100 Lorem Ave");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (82,"YaYa’s Flame Broiled Chicken","10:30:00","21:30:00","barbecue ","Ap #746-8952 Bibendum. Road");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (83,"Jon’s Diner","11:30:00","22:00:00","czech/slovak ","Ap #971-4888 Elit, Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (84,"Jimmy John’s","17:30:00","22:30:00","german ","333-9565 Ad Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (85,"Mary’s Cafe","16:30:00","23:30:00","chinese ","P.O. Box 581, 6442 Ornare Av.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (86,"Rich’s Fountain View Cafe","17:00:00","20:00:00","thai ","Ap #851-7056 Auctor Street");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (87,"Subway","11:00:00","23:30:00","mexican ","4862 Tristique St.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (88,"Ana Deli","8:30:00","14:00:00","indian ","248-777 Maecenas Av.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (89,"Little Caesars Pizza","15:00:00","20:00:00","mexican ","Ap #341-4892 Rutrum, Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (90,"Hungry Howie’s Pizza","10:30:00","22:00:00","mexican ","Ap #833-9613 Consequat Ave");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (91,"Burger King","17:00:00","21:30:00","chinese ","Ap #421-4690 Nunc Street");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (92,"Oscar’s Coney Island","11:00:00","22:30:00","indian ","Ap #408-6176 Ante Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (93,"Mr. Pita","17:30:00","22:30:00","japanese ","P.O. Box 918, 375 Arcu Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (94,"Fish City","11:30:00","22:00:00","chinese ","5496 Ligula. Ave");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (95,"Deli At Brewery Park","17:00:00","23:00:00","indian ","P.O. Box 882, 6132 Amet, Street");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (96,"Gold ‘n’ Greens","17:00:00","22:00:00","cafe ","321-891 Odio Road");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (97,"Burger King","11:00:00","22:30:00","cafe ","2749 Eros Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (98,"Church’s Fried Chicken","11:30:00","23:00:00","cafe ","871-3458 Ut, Street");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (99,"Freshii","11:00:00","22:30:00","cafe ","767-8115 Justo. Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (100,"Harmony & Soul","17:00:00","22:00:00","pizza ","Ap #504-2088 Erat. Road");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (101,"Bagley Cafe","17:00:00","22:30:00","pizza ","Ap #803-6368 Sollicitudin Avenue");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (102,"La Musique Restaurant","15:00:00","2:00:00","pizza ","Ap #882-4684 Placerat Avenue");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (103,"Peggy Day’s","10:30:00","22:00:00","pizza ","3152 Facilisis St.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (104,"Randy’s Sausage","17:00:00","21:30:00","pizza ","Ap #778-4269 Dis St.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (105,"Sbarro","11:00:00","22:30:00","pizza ","address");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (106,"Lajalisciense","17:30:00","22:30:00","fast ","Ap #415-3372 Integer St.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (107,"Starbucks","11:30:00","22:00:00","fast","P.O. Box 934, 9196 Aliquam Avenue");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (108,"Student Center","17:00:00","23:00:00","fast","P.O. Box 288, 7929 Arcu. Avenue");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (109,"You Name It","17:00:00","22:00:00","fast","5004 Ante Ave");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (110,"H & S Deli","17:00:00","22:30:00","fast","Ap #334-2573 Ut Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (111,"Mama Mia Pizzeria","11:00:00","22:30:00","fast","P.O. Box 680, 9002 Lobortis Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (112,"Rick’s Delight’s","6:00:00","22:30:00","mediterranean","6912 Et Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (113,"Lunchtime Global","6:30:00","18:00:00","mediterranean","2013 Nulla Ave");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (114,"Citgo - Mexican town Deli","7:00:00","20:30:00","mediterranean","776-1084 Urna St.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (117,"Deck","10:30:00","14:30:00","mediterranean","Ap #720-156 Eget, St.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (118,"Stoney Creek Brewery & Restaurant","6:00:00","0:00:00","mediterranean","877-6924 Tempus, Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (119,"Pizza Hut","11:30:00","0:00:00","mediterranean","923-6779 Ullamcorper. Ave");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (120,"Taco Bell","16:30:00","22:00:00","mediterranean","Ap #868-7380 Sem St.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (121,"Vernor Coney Island","17:00:00","23:00:00","mediterranean","Ap #193-7462 Purus Street");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (122,"Checkers","11:00:00","23:30:00","american ","P.O. Box 480, 2501 Odio, Road");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (123,"Club HQ","10:30:00","21:30:00","american ","8768 Dolor Ave");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (124,"Subway","11:30:00","22:00:00","american ","Ap #103-1352 Diam Road");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (125,"Domino’s Pizza","17:30:00","44679,8958333333","american ","2641 Nunc. St.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (126,"Maverick’s Food & Spirits","16:30:00","22:30:00","american ","4838 Vel, Av.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (127,"Quiznos","17:00:00","23:30:00","american ","P.O. Box 369, 1555 Elementum Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (128,"Family Fair Deli","11:00:00","20:00:00","american ","147-2603 Tristique St.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (129,"Shinola Cafe","8:30:00","23:30:00","american ","Ap #546-1423 Nibh Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (130,"James A Samborn","15:00:00","14:00:00","american ","257-2021 Et Road");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (131,"Epicurean Cafe","10:30:00","20:00:00","german ","Ap #454-5567 Felis, St.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (132,"Maxie’s Deli","17:00:00","22:00:00","japanese ","604-8283 Arcu Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (133,"G & T Management","11:00:00","21:30:00","vegetarian ","879-4022 Tristique Street");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (135,"United Fish Distributors","17:30:00","22:30:00","french ","355-350 Placerat, Road");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (136,"Flame Grill","11:30:00","22:30:00","african ","342-5579 Mauris Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (137,"Snack In the Box","17:00:00","22:00:00","american ","6763 Fusce Street");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (138,"Wingstop","17:00:00","23:00:00","barbecue ","7942 Suspendisse Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (139,"The Cook’s Crossing","11:00:00","22:00:00","czech/slovak ","Ap #779-4315 Lectus Road");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (140,"Panda Express","11:30:00","22:30:00","german ","975-7185 Lobortis. St.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (141,"Deli Unique of Detroit","11:00:00","23:00:00","chinese ","Ap #899-6961 Curabitur St.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (142,"Delilah’s Cafe","17:00:00","22:30:00","thai ","1692 Consequat Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (143,"KFC","17:00:00","22:00:00","mexican ","6678 Rhoncus. Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (144,"Nathan’s","15:00:00","22:30:00","indian ","532-6335 In Road");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (145,"Krispy Krunchy Chicken","10:30:00","2:00:00","african ","Ap #149-7813 Et St.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (146,"Central Market Grill","17:00:00","22:00:00","american ","735-5254 Dignissim. Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (147,"Bongs Noodles","11:00:00","21:30:00","barbecue ","Ap #961-1208 Erat Ave");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (148,"Forest’s Veggies","17:30:00","22:30:00","czech/slovak ","633-8985 Nisl Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (149,"Subway","11:30:00","22:30:00","german ","282-8538 Semper St.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (150,"Legends Grill","17:00:00","22:00:00","chinese ","853-3413 In Ave");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (151,"Midtown Express Cafe","17:00:00","23:00:00","thai ","Ap #743-1598 Non, Ave");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (152,"Cordoba Victor Hugo","17:00:00","22:00:00","mexican ","P.O. Box 866, 394 Luctus Ave");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (153,"Little Asia Inc","11:00:00","22:30:00","indian ","Ap #254-8100 In Road");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (154,"Star Coney Island","6:00:00","22:30:00","mexican ","P.O. Box 947, 1105 Feugiat Ave");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (155,"Harmonie Garden Cafe IV","6:30:00","22:30:00","mexican ","P.O. Box 828, 7470 Mi, Ave");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (156,"The Well","7:00:00","18:00:00","chinese ","Ap #436-7190 Nunc Av.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (157,"Acropolis Bakery","10:30:00","20:30:00","indian ","Ap #457-2481 Odio Road");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (158,"Delux Lounge","6:00:00","14:30:00","japanese ","830-6602 Diam Road");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (159,"Coldstone Creamery","11:30:00","0:00:00","chinese ","120-1724 Pellentesque Rd.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (160,"Eatori Market","16:30:00","0:00:00","indian ","461-2224 In Avenue");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (161,"Prime and Proper","17:00:00","22:00:00","cafe ","7065 Cras St.");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (162,"Detroit Water Ice Factory","11:00:00","23:00:00","cafe ","Ap #456-5372 At Rd.");
*/

INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (1,"7 Eleven","11:30:00","22:30:00","Super market ","3 Brigg Grove, Lincoln");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (2,"Applebee's","17:30:00","23:30:00","grill","62 Station Road, Sutton On Sea");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (3,"Arby's","16:30:00","20:00:00","Fast food","55 Kings Road, Metheringham");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (4,"Auntie Anne's","17:00:00","23:30:00","pretzels","6 Marjorie Avenue, Lincoln");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (5,"Baskin Robbins","11:00:00","14:00:00","Ice cream","31 Sandal Street, Lincoln");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (6,"Frisch's Big Boy","8:30:00","20:00:00","Fast food","183 Larne Road, Lincoln");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (7,"BJ's Restaurant & Brewhouse","15:00:00","22:00:00","american","9 Midholm, Cherry Willingham");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (8,"Bob Evans","10:30:00","21:30:00","american","5 Lynmouth Close, North Hykeham");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (9,"Bojangles","17:00:00","22:30:00","Fast food","33 Blenheim Road, Lincoln");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (10,"Bonefish Grill","11:00:00","22:30:00","grill","5 Horncastle Road, Wragby");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (11,"Boston Market","17:30:00","22:00:00","Super market ","23 George Street, Mablethorpe");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (12,"Burger King","11:30:00","23:00:00","Fast food","Rydans Plot, Bonthorpe Road, Willoughby");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (13,"California Pizza Kitchen","17:00:00","22:00:00","pizza","14 Temple Goring, Navenby");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (14,"Captain D's","17:00:00","22:30:00","Sea food","33 Woodfield Avenue, Lincoln");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (15,"Carl's Jr.","11:00:00","23:00:00","Fast food","Flat 1, Swiss Cottage, Willoughby Road, Sutton On Sea");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (16,"Carrabba's Italian Grill","11:30:00","22:30:00","italian","8 Sanders View, Lincoln");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (17,"Casey's General Store","11:00:00","22:00:00","Super market ","20 Grainsby Close, Lincoln");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (18,"Checker's Drive-In/Rallys","17:00:00","22:30:00","Fast food","11 Washingborough Road, Heighington");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (19,"Chick-Fil-A","17:00:00","2:00:00","Fast food","3 Highfield Terrace, North Hykeham");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (20,"Chili's","15:00:00","22:00:00","grill","Old Rectory Cottage, Church Lane, Willoughby");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (21,"Chipotle","10:30:00","21:30:00","Fast food","12 Deepdale Lane, Nettleham");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (22,"Chuck E. Cheese","17:00:00","22:30:00","Fast food","17 Cheviot Crescent, Coningsby");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (23,"Church's Chicken","11:00:00","22:30:00","Fast food","Meadow Rise, Strubby Road, Maltby Le Marsh");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (24,"Ci Ci's Pizza","17:30:00","22:00:00","pizza","27 Birch Grove, Alford");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (25,"Culver's","11:30:00","23:00:00","Fast food","42 George Street, Mablethorpe");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (26,"Dairy Queen","17:00:00","22:00:00","Fast food","Swallows Nest, Middlefield Lane, Glentham");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (27,"Del Taco","17:00:00","22:30:00","Fast food","3 Ticklepenny Walk, Louth");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (28,"Denny's","17:00:00","22:30:00","Fast food","258 Newark Road, Lincoln");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (29,"Dominos","11:00:00","22:30:00","pizza","Tritton House, Matilda Road, Lincoln");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (30,"Dunkin' Donuts","6:00:00","18:00:00","donuts","1A Painters Way, Sutton On Sea");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (31,"Einstein Bros","6:30:00","20:30:00","caffee","6 Pompeii Court, North Hykeham");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (32,"El Pollo Loco","7:00:00","14:30:00","grill","101 Grantham Road, Waddington");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (33,"Famous Dave's","10:30:00","0:00:00","grill","7B St Marys Street, Lincoln");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (34,"Firehouse Subs","6:00:00","0:00:00","sandwiches","1 The Paddock, Lincoln");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (35,"Five Guys","11:30:00","22:00:00","Fast food","East Row Farm, East Row, South Somercotes");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (36,"Friendly's","16:30:00","23:00:00","Fast food","63 Western Crescent, Lincoln");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (37,"Golden Corral","17:00:00","23:30:00","grill","14 Harpers Road, Lincoln");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (38,"Hardee's","11:00:00","21:30:00","Fast food","21 Ryland Bridge, Welton");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (39,"Hooters","10:30:00","22:00:00","Fast food","Wold View, Caistor Road, Swallow");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (40,"IHOP","11:30:00","44680,9166666667","caffee","9 Somerville Close, Waddington");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (41,"In-N-Out Burger","17:30:00","22:30:00","Fast food","41 Chaucer Drive, Lincoln");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (42,"Jack in the Box","16:30:00","23:30:00","Fast food","13 Hollywell Road, Lincoln");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (43,"Jamba Juice","17:00:00","20:00:00","juice","Haven Lodge, Haven Bank, New York");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (44,"Jason's Deli","11:00:00","23:30:00","Fast food","4 Steep Hill, Lincoln");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (45,"Jersey Mike's Subs","8:30:00","14:00:00","sandwiches","41 Main Street, Scothern");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (46,"Jimmy John's","15:00:00","20:00:00","sandwiches","9 Astwick Road, Lincoln");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (47,"Joe's Crab Shack","10:30:00","22:00:00","Sea food","128 Monks Road, Lincoln");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (48,"KFC","17:00:00","21:30:00","Fast food","1 Lancaster Way, Skellingthorpe");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (49,"Krispy Kreme","11:00:00","22:30:00","don","Westside Lodge, Cadney Road, Howsham");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (50,"Krystal","17:30:00","22:30:00","Fast food","6 Thorpe Road, Tattershall");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (51,"Little Caesars","11:30:00","22:00:00","pizza","12 Church View Crescent, Fiskerton");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (52,"Long John Silver's","17:00:00","23:00:00","Fast food","Grange Cottage, Keddington");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (53,"LongHorn Steakhouse","17:00:00","22:00:00","steakhouse","40 Eastgate, Louth");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (54,"McAlister's Deli","11:00:00","22:30:00","Fast casual","7 Dellfield Court, Lincoln");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (55,"McDonald's","11:30:00","23:00:00","Fast food","8 Cedar Close, Lincoln");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (56,"Moe's Southwest Grill","11:00:00","22:30:00","grill","Lindum Cottage, Chapel Walk, Scothern");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (57,"Noodles & Company","17:00:00","22:00:00","Fast casual","1 Tennyson Drive, Dunholme");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (58,"O'Charley's","17:00:00","22:30:00","Fast casual","171 Carlton Boulevard, Lincoln");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (59,"Olive Garden","15:00:00","2:00:00","italian","3 Canwick Hall Mews, Canwick");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (60,"On the Border","10:30:00","22:00:00","mexican","39 Foundry Street, Horncastle");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (61,"Outback Steakhouse","17:00:00","21:30:00","steakhouse","Moat Grange, Cumberworth");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (62,"Panda Express","11:00:00","22:30:00","Fast food","2 Clover Road, Willoughby");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (63,"Panera Bread","17:30:00","22:30:00","Fast casual","7 Blanchard Road, Louth");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (64,"Papa John's","11:30:00","22:00:00","pizza","Wood View Cottage, Timberland Fen");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (65,"Papa Murphy's","17:00:00","23:00:00","pizza","9 Old Paddock Court, Horncastle");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (66,"Perkins","17:00:00","22:00:00","pizza","Campaign Farm, South Ormsby");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (67,"PF Chang's","17:00:00","22:30:00","Fast casual","2 Royal Oak Lane, Washingborough");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (68,"Pizza Hut","11:00:00","22:30:00","pizza","56 Kidgate, Louth");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (69,"Popeyes","6:00:00","22:30:00","Fast food","Unit 25, Lincoln Enterprise Park, Newark Road, Aubourn");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (70,"Qdoba","6:30:00","18:00:00","mexican","Grey Bear Lodge, 16 Craypool Lane, Scothern");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (71,"Quiznos","7:00:00","20:30:00","Fast food","3 Lillys Road, Lincoln");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (72,"Red Lobster","10:30:00","14:30:00","Sea food","19 Churchill Avenue, Market Rasen");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (73,"Red Robin","6:00:00","0:00:00","Fast food","5 York Terrace, Billinghay");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (74,"Romano's Macaroni Grill","11:30:00","0:00:00","grill","20 St Helens Avenue, Lincoln");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (75,"Round Table Pizza","16:30:00","22:00:00","pizza","42 Lime Walk, Market Rasen");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (76,"Ruby Tuesday","17:00:00","23:00:00","Fast food","19 Canal Close, Louth");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (77,"Sbarro","11:00:00","23:30:00","italian","Mere Oak Cottage, Plough Hill, Potterhanworth");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (78,"Sheetz","10:30:00","21:30:00","Super market ","Marellis, North Lane, Swaby");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (79,"Sonic","11:30:00","22:00:00","Fast food","1 James Court, Welton");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (80,"Starbucks","17:30:00","22:30:00","caffee","349 High Street, Lincoln");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (81,"Steak 'N Shake","16:30:00","23:30:00","Fast food","1 St Annes Close, Lincoln");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (82,"Subway","17:00:00","20:00:00","Fast food","4 Yale Close, Washingborough");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (83,"Taco Bell","11:00:00","23:30:00","Fast food","54 Sincil Bank, Lincoln");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (84,"TGI Friday's","8:30:00","14:00:00","american","Thyme Cottage, Whitepit Way, Swaby");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (85,"The Capital Grille","15:00:00","20:00:00","grill","45 Windsor Close, Sudbrooke");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (86,"Tim Hortons","10:30:00","22:00:00","Fast food","4 David Avenue, Louth");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (87,"Wawa","17:00:00","21:30:00","Super market ","3 Manor Close, Metheringham");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (88,"Wendy's","11:00:00","22:30:00","Fast food","54 Somerville Close, Waddington");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (89,"Whataburger","17:30:00","22:30:00","Fast food","4 Anzio Crescent, Lincoln");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (90,"White Castle","11:30:00","22:00:00","Fast food","1 Hilton Court, Saxilby");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (91,"Wingstop","17:00:00","23:00:00","Fast food","14 High Street, Mablethorpe");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (92,"Yard House","17:00:00","22:00:00","bar","37 Grantham Road, Waddington");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (93,"Zaxby's","11:00:00","22:30:00","Fast casual","18 Malton Road, North Hykeham");
INSERT INTO RESTAURANT (idRestaurant,name,opens,closes,category,address) VALUES (94,"Marco's Pizza","11:30:00","23:00:00","pizza","White Cloud, Woodhall Road, Tattershall Thorpe");

/* OWNER */


INSERT INTO OWNER (idUser, idRestaurant) VALUES (1,1);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (2,2);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (3,3);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (4,4);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (5,5);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (6,6);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (7,7);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (8,8);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (9,9);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (10,10);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (11,11);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (12,12);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (13,13);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (14,14);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (15,15);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (16,16);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (17,17);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (18,18);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (19,19);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (20,20);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (21,21);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (22,22);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (23,23);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (24,24);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (25,25);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (26,26);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (27,27);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (28,28);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (29,29);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (30,30);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (31,31);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (32,32);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (33,33);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (34,34);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (35,35);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (36,36);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (37,37);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (38,38);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (39,39);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (40,40);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (41,41);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (42,42);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (43,43);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (44,44);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (45,45);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (46,46);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (47,47);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (48,48);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (49,49);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (50,50);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (51,51);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (52,52);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (53,53);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (54,54);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (55,55);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (56,56);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (57,57);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (58,58);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (59,59);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (60,60);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (61,61);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (62,62);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (63,63);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (64,64);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (65,65);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (66,66);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (67,67);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (68,68);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (69,69);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (70,70);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (71,71);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (72,72);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (73,73);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (74,74);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (75,75);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (76,76);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (77,77);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (78,78);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (79,79);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (80,80);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (81,81);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (82,82);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (83,83);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (84,84);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (85,85);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (86,86);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (87,87);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (88,88);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (89,89);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (90,90);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (91,91);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (92,92);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (93,93);
INSERT INTO OWNER (idUser, idRestaurant) VALUES (94,94);


/* dish */


