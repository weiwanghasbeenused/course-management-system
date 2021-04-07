
    
    CREATE TABLE IF NOT EXISTS `Class`  (
        `id` integer not null auto_increment,
        `name` varchar(255) not null,
        `classroom` varchar(255),
        `comment` longtext,
        `student_number` integer,
        `fk_Contact` integer,
        `fk_InvitationBranch` integer,
        `active` integer(1) unsigned not null default 1,
        primary key (`id`)
    ) engine=InnoDB;
    
    CREATE TABLE IF NOT EXISTS `Contact` (
        `id` integer not null auto_increment,
        `name` varchar(255) not null,
        `name2` varchar(255) not null,
        `mobile` varchar(255),
        `phone` varchar(255),
        `phone2` varchar(255),
        `email` varchar(255),
        `fk_InvitationBranch` integer,
        `active` integer(1) unsigned not null default 1,
        primary key (`id`)
    ) engine=InnoDB;
    
    CREATE TABLE IF NOT EXISTS `Course` (
        `id` integer not null auto_increment,
        `name` varchar(255) not null,
        `course_type` varchar(255),
        `hourly_rate` double precision not null,
        `total_hours` integer not null,
        `is_valid` bit,
        `active_since` date not null,        
        `register_date` date not null,
        `comment` varchar(255),
        `fk_Class` integer,
        `active` integer(1) unsigned not null default 1,
        primary key (`id`)
    ) engine=InnoDB;
    
    CREATE TABLE IF NOT EXISTS `InvitationBranch` (
        `id` integer not null auto_increment,
        `name` varchar(255) not null,
        `address` varchar(255),
        `fk_InvitationUnit` integer,
        `active` integer(1) unsigned not null default 1,
        primary key (`id`)
    ) engine=InnoDB;
    
    CREATE TABLE IF NOT EXISTS `InvitationUnit` (
        `id` integer not null auto_increment,
        `name` varchar(255) not null,
        `address` varchar(255),
        `vat_number` varchar(255) not null,
        `abbreviation` varchar(255),
        `url` varchar(255),
        `active` integer(1) unsigned not null default 1,
        primary key (`id`)
    ) engine=InnoDB;
    
    CREATE TABLE IF NOT EXISTS `Invoice` (
        `id` integer not null auto_increment,
        `comment` longtext,
        `description` varchar(255) not null,
        `invoice_number` varchar(255) not null,
        `subtotal` integer not null,
        `total` integer not null,
        `vat` integer not null,
        `fk_Payment` integer,
        `active` integer(1) unsigned not null default 1,
        primary key (`id`)
    ) engine=InnoDB;
    
    CREATE TABLE IF NOT EXISTS `InvoiceDetail` (
        `id` integer not null auto_increment,
        `amount` integer not null,
        `unit_price` integer not null,
        `fk_Invoice` integer,
        `active` integer(1) unsigned not null default 1,
        primary key (`id`)
    ) engine=InnoDB;
    
    CREATE TABLE IF NOT EXISTS `Payment` (
        `id` integer not null auto_increment,
        `bank_account` varchar(255),
        `bank_name` varchar(255),
        `check_number` varchar(255),
        `payment_date` date not null,
        `total_payment` integer not null,
        `active` integer(1) unsigned not null default 1,
        primary key (`id`)
    ) engine=InnoDB;
    
    CREATE TABLE IF NOT EXISTS `Teaching` (
        `id` integer not null auto_increment,
        `comment` longtext,
        `end_date` date not null,
        `start_date` date not null,
        `fk_Contact` integer,
        `fk_Course` integer,
        `fk_Invoice` integer,
        `active` integer(1) unsigned not null default 1,
        primary key (`id`)
    ) engine=InnoDB;
    
    -- ALTER TABLE `Invoice` 
       -- DROP index UKcqj58sins5nhm8bd45riyeoxv;
    
    ALTER TABLE `Invoice` 
       add constraint UKcqj58sins5nhm8bd45riyeoxv unique (invoice_number);
    
    ALTER TABLE `Class` 
       add constraint FK9o9v16w7e8r9jrio18o02tmgc 
       foreign key (fk_Contact) 
       references Contact (id);
    
    ALTER TABLE `Class` 
       add constraint FKbgu9s92yyi8kbwadw4v2drn5n 
       foreign key (fk_InvitationBranch) 
       references InvitationBranch (id);
    
    ALTER TABLE `Contact` 
       add constraint FKc7mqm99kvvanwtshp1qxt9iw3 
       foreign key (fk_InvitationBranch) 
       references InvitationBranch (id);
    
    ALTER TABLE `Course` 
       add constraint FK1pseexid1jtyl5u06rhe50wsf 
       foreign key (fk_Class) 
       references Class (id);
    
    ALTER TABLE `InvitationBranch` 
       add constraint FKc6564x3tc1b2iso19wabm37su 
       foreign key (fk_InvitationUnit) 
       references InvitationUnit (id);
    
    ALTER TABLE `Invoice` 
       add constraint FKebyr4sq71ul26j0nj0mw4xi12 
       foreign key (fk_Payment) 
       references Payment (id);
    
    ALTER TABLE `InvoiceDetail` 
       add constraint FK4stjwsg7x82el0c1uhkerskj4 
       foreign key (fk_Invoice) 
       references Invoice (id);
    
    ALTER TABLE `Teaching` 
       add constraint FK52m4jrw2qkx5jlbh096c1te86 
       foreign key (fk_Contact) 
       references Contact (id);
    
    ALTER TABLE `Teaching` 
       add constraint FKsl8ewhhysr5xgb4cp0f2jknhn 
       foreign key (fk_Course) 
       references Course (id);
    
    ALTER TABLE `Teaching` 
       add constraint FKer457ngpsmspyh3fddcy3ebpk 
       foreign key (fk_Invoice) 
       references Invoice (id);