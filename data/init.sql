-- drop database pcrud;
-- drop table footballers;
-- drop table positions;
-- drop table clubs;

create database pcrud
;
use pcrud
;

-- //////////

create table footballers (
	fbid int not null auto_increment,
	fbname varchar(255) not null,
	clubid int,
	postid int,
	created timestamp not null default current_timestamp,
	updated timestamp not null default current_timestamp,
	primary key (fbid)
)
;
create table positions (
	postid int not null auto_increment,
	posname varchar(255),
	created timestamp not null default current_timestamp,
	updated timestamp not null default current_timestamp,
	primary key (postid)
)
;
create table clubs (
	clubid int not null auto_increment,
	clubname varchar(255),
	created timestamp not null default current_timestamp,
	updated timestamp not null default current_timestamp,
	primary key (clubid)
)
;

-- //////////

-- positions data
insert into positions(posname)
values('Goalkeeper')
;
insert into positions(posname)
values('Centre-Back')
;
insert into positions(posname)
values('Left-Back')
;
insert into positions(posname)
values('Right-Back')
;
insert into positions(posname)
values('Defensive Midfield')
;
insert into positions(posname)
values('Central Midfield')
;
insert into positions(posname)
values('Central Midfield')
;
insert into positions(posname)
values('Attacking Midfield')
;
insert into positions(posname)
values('Left Winger')
;
insert into positions(posname)
values('Right Winger')
;
insert into positions(posname)
values('Centre-Forward')
;

-- clubs data
insert into clubs(clubname)
values('Liverpool')
;
insert into clubs(clubname)
values('Arsenal')
;
insert into clubs(clubname)
values('Aston Villa')
;
insert into clubs(clubname)
values('Manchester City')
;
insert into clubs(clubname)
values('Tottenham Hotspur')
;
insert into clubs(clubname)
values('Manchester United')
;

-- footballers data
insert into footballers(fbname, clubid, postid)
values('Alisson', 1, 1)
;
insert into footballers(fbname, clubid, postid)
values('Caoimhín Kelleher', 1, 1)
;
insert into footballers(fbname, clubid, postid)
values('Adrián', 1, 1)
;
insert into footballers(fbname, clubid, postid)
values('Ibrahima Konaté', 1, 2)
;
commit
;