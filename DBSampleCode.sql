DROP TABLE IF EXISTS `reservations`, `books`, `categories`, `users`;
DROP USER IF EXISTS'alanjmckenna'@'localhost';
DROP USER IF EXISTS 'joecrotty'@'localhost';
DROP USER IF EXISTS 'tommy100'@'localhost';

CREATE TABLE `users` 
(
    Username varchar(30) PRIMARY KEY,
    Password varchar(6), 
    FirstName varchar(30), 
    Surname varchar(30), 
    AddressLine1 varchar(30), 
    AddressLine2 varchar(30), 
    City varchar(30), 
    Telephone varchar(10), 
    Mobile varchar(10)
);

CREATE TABLE `categories` 
(
    CategoryID varchar(3) PRIMARY KEY,
    CategoryDescription varchar(30)
    
);

CREATE TABLE `books` 
(
    ISBN varchar(30) PRIMARY KEY, 
    BookTitle varchar(30), 
    Author varchar(30), 
    Edition int(1), 
    Year year, 
    CategoryID varchar(3), 
    Reserved varchar(1),
    FOREIGN KEY (CategoryID) REFERENCES categories(CategoryID)
);

CREATE TABLE `reservations` 
(
    ISBN varchar(30), 
    Username varchar(30), 
    ReservedDate date,
    FOREIGN KEY (ISBN) REFERENCES books(ISBN),
    FOREIGN KEY (Username) REFERENCES users(Username)
);


INSERT INTO `users` (Username, Password, FirstName, Surname, AddressLine1, AddressLine2, City, Telephone, Mobile) VALUES
    ('alanjmckenna', 't1234s', 'Alan', 'McKenna', '38 Cranley Road', 'Fairview', 'Dublin', 9998377, 856625567),
    ('joecrotty', 'kj7899', 'Joseph', 'Crotty', 'Apt 5 Clyde Road', 'Donnybrook', 'Dublin', 8887889, 876654456),
    ('tommy100', '123456', 'tom', 'behan', '14 hyde road', 'dalkey', 'dublin', 9983747, 876738782);




INSERT INTO `categories` (CategoryID, CategoryDescription) VALUES
    ('001', 'Health'),
    ('002', 'Business'),
    ('003', 'Biography'),
    ('004', 'Technology'),
    ('005', 'Travel'),
    ('006', 'Self-Help'),
    ('007', 'Cookery'),
    ('008', 'Fiction'),
    ('009', 'History');

INSERT INTO `books` (ISBN, BookTitle, Author, Edition, Year, CategoryID, Reserved) VALUES
    ('093-403992', 'Computers in Business', 'Alicia Oneill', 3, '1997', '004', 'N'),
    ('23472-8729', 'Exploring Peru', 'Stephanie Birchington', 4, '2005', '005','N'),
    ('237-34823', 'Business Strategy', 'Joe Peppard', 2, '1997', '002', 'N'),
    ('23u8-923849', 'A guide to nutrition', 'John Thorpe', 2, '1997', '001', 'N'),
    ('2983-3494', 'Cooking for children', 'Anabelle Sharpe', 1, '2003', '007', 'N'),
    ('82n8-308', 'Computers for Idiots', 'Susan O`Neill', 5, '1998', '004', 'N'),
    ('9823-23984', 'My Life in Picture', 'Kevin Graham', 8, '2004', '003', 'N'),
    ('9823-2403-0', 'DaVinci Code', 'Dan Brown', 1, '2003', '008', 'N'),
    ('98234-029384', 'My Ranch in Texas', 'George Bush', 1, '2005', '003', 'Y'),
    ('9823-98345', 'How to cook Italian food', 'Jamie Oliver', 2, '2005', '007', 'Y'),
    ('9823-98487', 'Optimising your Business', 'Cleo Blair', 1, '2001', '002', 'N'),
    ('988745-234', 'Tara Road', 'Maeve Binchy', 4, '2002', '008', 'N'),
    ('993-004-00', 'My Life in Bits', 'John Smith', 1, '2001', '003', 'N'),
    ('9987-0039882', 'Shooting History', 'Jon Snow', 1, '2003', '009', 'N'),
    ('9956-12735', 'Mental Health Advice', 'Mental John', 2, '2001', '006', 'N'),
    ('993040-127', 'Dune', 'Frank Herbert', 4, '1969', '008', 'N'),
    ('993240-127', 'Dune Messiah', 'Frank Herbert', 4, '1976', '008', 'N'),
    ('993440-127', 'Children of Dune', 'Frank Herbert', 4, '1990', '008', 'N');


INSERT INTO `reservations` (ISBN, Username, ReservedDate) VALUES
    ('98234-029384', 'joecrotty', '2008-10-11'),
    ('9823-98345', 'tommy100', '2008-10-11');
    

CREATE USER 'alanjmckenna'@'localhost' IDENTIFIED BY 't1234s';
GRANT SELECT, INSERT, UPDATE ON librarydb.* TO 'alanjmckenna'@'localhost';

CREATE USER 'joecrotty'@'localhost' IDENTIFIED BY 'kj7899';
GRANT SELECT, INSERT, UPDATE ON librarydb.* TO 'joecrotty'@'localhost';

CREATE USER 'tommy100'@'localhost' IDENTIFIED BY '123456';
GRANT SELECT, INSERT, UPDATE ON librarydb.* TO 'tommy100'@'localhost';
