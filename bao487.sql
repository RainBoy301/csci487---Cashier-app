-- Created by Vertabelo (http://vertabelo.com)
-- Last modification date: 2020-10-04 21:58:36.612

-- tables
-- Table: Employee
-- Created by Vertabelo (http://vertabelo.com)
-- Last modification date: 2020-10-04 21:58:36.612

-- foreign keys
ALTER TABLE Users
    DROP FOREIGN KEY Employee_Users;

ALTER TABLE Users
    DROP FOREIGN KEY Owner_Users;

ALTER TABLE Ticket
    DROP FOREIGN KEY Service_Ticket;

ALTER TABLE Employee
    DROP FOREIGN KEY Ticket_Employee;

ALTER TABLE Owner
    DROP FOREIGN KEY Ticket_Owner;

-- tables
DROP TABLE Employee;

DROP TABLE Owner;

DROP TABLE Service;

DROP TABLE Ticket;

DROP TABLE Users;

-- End of file.


CREATE TABLE Employee (
    employeeID int NOT NULL,
    First_Name varchar(10),
    Last_Name varchar(10),
    Money_Collected double,
    Commission double,
    Unchecked_Ticket boolean,
    Current_TicketID int,
    CONSTRAINT Employee_pk PRIMARY KEY (employeeID)
);

-- Table: Owner
CREATE TABLE Owner (
    ownerID int NOT NULL,
    First_Name varchar(10),
    Last_Name varchar(10),
    Money_Collected double,
    Unchecked_Ticket boolean,
    Current_TicketID int,
    CONSTRAINT Owner_pk PRIMARY KEY (ownerID)
);

-- Table: Service
CREATE TABLE Service (
    serviceID int NOT NULL AUTO_INCREMENT,
    Service_Name varchar(20) NOT NULL,
    Service_Price double NOT NULL,
    CONSTRAINT Service_pk PRIMARY KEY (serviceID)
);

-- Table: Ticket
CREATE TABLE Ticket (
    userID int NOT NULL,
    TicketID int NOT NULL,
    serviceID int NOT NULL,
    quantity int NOT NULL,
    times datetime NOT NULL,
    total int NOT NULL,
    Pay_Type character(1) NOT NULL,
    CONSTRAINT Ticket_pk PRIMARY KEY (userID,TicketID)
);

-- Table: Users
CREATE TABLE Users (
    userID int NOT NULL AUTO_INCREMENT,
    userName varchar(20) NOT NULL,
    hashed_password varchar(60) NOT NULL,
    userType character(1) NOT NULL,
    CONSTRAINT Users_pk PRIMARY KEY (userID)
);

-- foreign keys
-- Reference: Employee_Users (table: Users)
ALTER TABLE Users ADD CONSTRAINT Employee_Users FOREIGN KEY Employee_Users (userID)
    REFERENCES Employee (employeeID);

-- Reference: Owner_Users (table: Users)
ALTER TABLE Users ADD CONSTRAINT Owner_Users FOREIGN KEY Owner_Users (userID)
    REFERENCES Owner (ownerID);

-- Reference: Service_Ticket (table: Ticket)
ALTER TABLE Ticket ADD CONSTRAINT Service_Ticket FOREIGN KEY Service_Ticket (serviceID)
    REFERENCES Service (serviceID);

-- Reference: Ticket_Employee (table: Employee)
ALTER TABLE Employee ADD CONSTRAINT Ticket_Employee FOREIGN KEY Ticket_Employee (employeeID,Current_TicketID)
    REFERENCES Ticket (userID,TicketID);

-- Reference: Ticket_Owner (table: Owner)
ALTER TABLE Owner ADD CONSTRAINT Ticket_Owner FOREIGN KEY Ticket_Owner (ownerID,Current_TicketID)
    REFERENCES Ticket (userID,TicketID);

-- End of file.
