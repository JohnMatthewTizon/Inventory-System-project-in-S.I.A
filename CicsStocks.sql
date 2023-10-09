-- Create the database
CREATE DATABASE YourDatabaseName;

-- Use the database
USE YourDatabaseName;

-- Create the AdminLogin table
CREATE TABLE AdminLogin (
    AdminID INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(50) NOT NULL,
    Password VARCHAR(100) NOT NULL,
    EmployeeID INT,
    FOREIGN KEY (EmployeeID) REFERENCES EmployeeInformation(EmployeeID)
);

-- Create the EmployeeInformation table
CREATE TABLE EmployeeInformation (
    EmployeeID INT PRIMARY KEY AUTO_INCREMENT,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50) NOT NULL,
    -- Other employee fields
);

-- Create the Suppliers table
CREATE TABLE Suppliers (
    SupplierID INT PRIMARY KEY AUTO_INCREMENT,
    SupplierName VARCHAR(100) NOT NULL,
    -- Other supplier fields
);

-- Create the Products table
CREATE TABLE Products (
    ProductID INT PRIMARY KEY AUTO_INCREMENT,
    ProductName VARCHAR(100) NOT NULL,
    SupplierID INT,
    FOREIGN KEY (SupplierID) REFERENCES Suppliers(SupplierID),
    -- Other product fields
);

-- Create the Delivery table
CREATE TABLE Delivery (
    DeliveryID INT PRIMARY KEY AUTO_INCREMENT,
    ProductID INT,
    DeliveryDate DATE,
    QuantityReceived INT,
    SupplierID INT,
    FOREIGN KEY (ProductID) REFERENCES Products(ProductID),
    FOREIGN KEY (SupplierID) REFERENCES Suppliers(SupplierID)
);

-- Create the StockTransactions table
CREATE TABLE StockTransactions (
    TransactionID INT PRIMARY KEY AUTO_INCREMENT,
    ProductID INT,
    TransactionType ENUM('In', 'Out') NOT NULL,
    TransactionDate DATE,
    Quantity INT,
    EmployeeID INT,
    FOREIGN KEY (ProductID) REFERENCES Products(ProductID),
    FOREIGN KEY (EmployeeID) REFERENCES EmployeeInformation(EmployeeID)
);