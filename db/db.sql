create table user(
    user_id int not null auto_increment,
    name varchar(50) not null,
    password varchar(255) not null,
    role enum('student', 'admin', 'super admin', 'reviewer'),
    email varchar(255) not null,
    image varchar(255) not null default 'placeholder.jpg',
    primary key (user_id),
    unique key (email)
);

create table student(
    user_id int not null auto_increment,
    university varchar(100) not null default '',
    major varchar(100) not null default '',
    level enum('Undergraduate', 'Postgraduate', 'Doctoral') default 'Undergraduate',
    street varchar(255) not null default '',
    city varchar(255) not null default '',
    zipcode int not null default 0,
    primary key (user_id),
    foreign key(user_id) references user(user_id) on delete cascade
);

create table administrator(
    user_id int not null auto_increment,
    organization varchar(50) not null,
    primary key (user_id),
    foreign key(user_id) references user(user_id) on delete cascade
);

create table reviewer(
    user_id int not null,
    occupation varchar(255) not null,
    score int not null,
    primary key (user_id),
    foreign key(user_id) references user(user_id) on delete cascade
);

create table superAdmin(
    user_id int not null auto_increment,
    primary key (user_id),
    foreign key(user_id) references user(user_id) on delete cascade
);

create table scholarship(
    user_id int not null,
    scholarship_id int not null,
    title varchar(50) not null,
    description longtext,
    coverage int not null,
    contact_name varchar(50) not null,
    contact_email varchar(50) not null,
    primary key (user_id, scholarship_id),
    foreign key (user_id) references administrator(user_id) on delete cascade
);

create table scholarshipType(
    user_id int not null,
    scholarship_id int not null,
    type varchar(50) not null,
    primary key (user_id, scholarship_id, type),
    foreign key (user_id, scholarship_id) references scholarship(user_id, scholarship_id) on delete cascade
);

create table additionalFiles(
    user_id int not null,
    file_id int not null,
    type varchar(50) not null,
    link varchar(255) not null,
    primary key (user_id, file_id),
    foreign key (user_id) references student(user_id) on delete cascade
);

create table bookmark(
    user_id_student int not null,
    user_id_scholarship int not null,
    scholarship_id int not null,
    priority int not null,
    primary key(user_id_student, user_id_scholarship, scholarship_id),
    foreign key(user_id_student) references student(user_id),
    foreign key(user_id_scholarship, scholarship_id) references scholarship(user_id, scholarship_id) on delete cascade
);

create table review(
    user_id_reviewer int not null,
    user_id_student int not null,
    file_id int not null,
    review_status enum('waiting', 'reviewed'),
    comment longtext,
    primary key (user_id_reviewer, user_id_student, file_id),
    foreign key (user_id_reviewer) references reviewer(user_id),
    foreign key (user_id_student, file_id) references additionalFiles(user_id, file_id)
);

insert into user(user_id, name, password, role, email) 
values (1, 'Admin Beasiswa', '$2y$10$o8EcCzkJN1id5X.Yja/hS.dLPHP7JQyOP.uZ0JKb3Fs1khgaEaeWm', 'admin', 'admin1@beasiswah.com');

insert into administrator(user_id, organization)
values(1, 'Metaverse Lab');

insert into user(user_id, name, password, role, email)
values(2,'Jenderal Daemon', '$2y$10$o8EcCzkJN1id5X.Yja/hS.dLPHP7JQyOP.uZ0JKb3Fs1khgaEaeWm', 'super admin', 'jenderal@daemon.sparta');

insert into superAdmin(user_id)
values(2);