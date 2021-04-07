
    
    CREATE TABLE IF NOT EXISTS `Class`  (
       `classId` integer not null auto_increment,
        `Class_Name` varchar(255) not null,
        `Classroom_Code` varchar(255),
        `comment` longtext,
        `Student_Number` integer,
        `FK_ContactId` integer,
        `FK_BranchId` integer,
        `active` integer(1) unsigned not null default 1,
        primary key (`classId`)
    ) engine=InnoDB;
    
    CREATE TABLE IF NOT EXISTS `Contact` (
       contactId integer not null auto_increment,
        Contact_Mobile varchar(255),
        Contact_Name varchar(255) not null,
        Contact_Phone varchar(255),
        Contact_Phone2 varchar(255),
        email varchar(255),
        FK_BranchId integer,
        active integer(1) unsigned not null default 1,
        primary key (contactId)
    ) engine=InnoDB;
    
    CREATE TABLE IF NOT EXISTS `Course` (
       courseId integer not null auto_increment,
        Hourly_Rate double precision not null,
        IsStill_Valid bit,
        Active_Since date not null,
        Course_Name varchar(255) not null,
        Course_Type varchar(255),
        prerequisite varchar(255),
        Register_Date date not null,
        Total_Hours integer not null,
        FK_ClassId integer,
        primary key (courseId)
    ) engine=InnoDB;
    
    CREATE TABLE IF NOT EXISTS `InvitationBranch` (
       branchId integer not null auto_increment,
        Address varchar(255),
        Branch_Name varchar(255) not null,
        FK_UnitId varchar(255),
        primary key (branchId)
    ) engine=InnoDB;
    
    CREATE TABLE IF NOT EXISTS `InvitationUnit` (
       unitId varchar(255) not null,
        Address varchar(255),
        VAT_Number varchar(255) not null,
        abbreviation varchar(255),
        Unit_Name varchar(255) not null,
        URL varchar(255),
        primary key (unitId)
    ) engine=InnoDB;
    
    CREATE TABLE IF NOT EXISTS `Invoice` (
       invoiceId integer not null auto_increment,
        comment longtext,
        Description varchar(255) not null,
        Invoice_No varchar(255) not null,
        Subtotal integer not null,
        Total integer not null,
        VAT integer not null,
        FK_PaymentId integer,
        primary key (invoiceId)
    ) engine=InnoDB;
    
    CREATE TABLE IF NOT EXISTS `InvoiceDetail` (
       DetailId integer not null auto_increment,
        amount integer not null,
        Unit_Price integer not null,
        FK_InvoiceId integer,
        primary key (DetailId)
    ) engine=InnoDB;
    
    CREATE TABLE IF NOT EXISTS `Payment` (
       paymentId integer not null auto_increment,
        Bank_Account varchar(255),
        Bank_Name varchar(255),
        Check_No varchar(255),
        Payment_Date date not null,
        Total_Payment integer not null,
        primary key (paymentId)
    ) engine=InnoDB;
    
    CREATE TABLE IF NOT EXISTS `Teaching` (
       teachingId integer not null auto_increment,
        comment longtext,
        End_Date date not null,
        Start_Date date not null,
        FK_ContactId integer,
        FK_CourseId integer,
        FK_InvoiceId integer,
        primary key (teachingId)
    ) engine=InnoDB;
    
    -- ALTER TABLE `Invoice` 
       -- DROP index UKcqj58sins5nhm8bd45riyeoxv;
    
    ALTER TABLE `Invoice` 
       add constraint UKcqj58sins5nhm8bd45riyeoxv unique (Invoice_No);
    
    ALTER TABLE `Class` 
       add constraint FK9o9v16w7e8r9jrio18o02tmgc 
       foreign key (FK_ContactId) 
       references Contact (contactId);
    
    ALTER TABLE `Class` 
       add constraint FKbgu9s92yyi8kbwadw4v2drn5n 
       foreign key (FK_BranchId) 
       references InvitationBranch (branchId);
    
    ALTER TABLE `Contact` 
       add constraint FKc7mqm99kvvanwtshp1qxt9iw3 
       foreign key (FK_BranchId) 
       references InvitationBranch (branchId);
    
    ALTER TABLE `Course` 
       add constraint FK1pseexid1jtyl5u06rhe50wsf 
       foreign key (FK_ClassId) 
       references Class (classId);
    
    ALTER TABLE `InvitationBranch` 
       add constraint FKc6564x3tc1b2iso19wabm37su 
       foreign key (FK_UnitId) 
       references InvitationUnit (unitId);
    
    ALTER TABLE `Invoice` 
       add constraint FKebyr4sq71ul26j0nj0mw4xi12 
       foreign key (FK_PaymentId) 
       references Payment (paymentId);
    
    ALTER TABLE `InvoiceDetail` 
       add constraint FK4stjwsg7x82el0c1uhkerskj4 
       foreign key (FK_InvoiceId) 
       references Invoice (invoiceId);
    
    ALTER TABLE `Teaching` 
       add constraint FK52m4jrw2qkx5jlbh096c1te86 
       foreign key (FK_ContactId) 
       references Contact (contactId);
    
    ALTER TABLE `Teaching` 
       add constraint FKsl8ewhhysr5xgb4cp0f2jknhn 
       foreign key (FK_CourseId) 
       references Course (courseId);
    
    ALTER TABLE `Teaching` 
       add constraint FKer457ngpsmspyh3fddcy3ebpk 
       foreign key (FK_InvoiceId) 
       references Invoice (invoiceId);