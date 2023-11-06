create table university(
    university_id int not null auto_increment,
    name varchar(255) not null,
    primary key(university_id)
);

create table user(
    user_id int not null auto_increment,
    name varchar(50) not null,
    password varchar(255) not null,
    role enum('student', 'admin', 'super admin', 'reviewer'),
    email varchar(255) not null,
    image varchar(255) not null default 'placeholder.jpg',
    reset_token varchar(64) null default null,
    is_verified boolean not null default false,
    verify_token varchar(64) null default null,
    primary key (user_id),
    unique key (email)
);

create table student(
    user_id int not null auto_increment,
    univ_id int not null,
    major varchar(100) not null default '',
    level enum('Undergraduate', 'Postgraduate', 'Doctoral') default 'Undergraduate',
    street varchar(255) not null default '',
    city varchar(255) not null default '',
    zipcode int not null default 0,
    primary key (user_id),
    foreign key(user_id) references user(user_id) on delete cascade,
    foreign key(univ_id) references university(university_id),
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
    short_description varchar(255),
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
    foreign key (user_id_reviewer) references reviewer(user_id) on delete cascade,
    foreign key (user_id_student, file_id) references additionalFiles(user_id, file_id) on delete cascade
);