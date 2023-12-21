Drop table if exists bet,Guests, Team, Capitain, Match, Articles, Inscription, Run cascade;

create table Team (
                      teamName text unique not null primary key,
                      winsCount int not null,
                      goalFor int not null,
                      goalAgainst int not null
);

create table Guests (
                        username text unique not null primary key,
                        mail text unique not null,
                        name text not null,
                        firstname text not null,
                        birthday date not null,
                        password text not null,
                        isPlayer boolean not null,
                        isAdmin boolean not null,
                        isRegistered boolean not null,
                        isDeleted boolean not null,
                        Team text
);

create table Capitain (
                          username text unique not null,
                          teamName text unique not null references Team,
                          primary key(username, teamName)
);

create table Articles (
                          idArticle serial not null primary key,
                          title text not null,
                          contenu text not null,
                          writer text not null references Guests,
                          datePublication date not null,
                          image_data bytea
);

create table Run (
                     title text unique not null primary key,
                     image_data bytea not null,
                     starterPoint text not null,
                     finalPoint text not null,
                     orderRun int not null,
                     maxBet int not null check (maxBet>=0)
);

create table Match (
                       idmatch serial primary key,
                       attack text not null references Team,
                       defend text not null references team,
                       betTeamKept int,
                       goal int not null,
                       score int not null,
                       runTitle text ,
                       contestation boolean
);

create table bet(
                    username text not null references Guests,
                    idmatch int not null references Match,
                    betcap int,
                    primary key(username,idmatch)
);

create table Inscription (
                             open boolean unique not null primary key
);

insert into Inscription
values (true);


/* Jeu de test*/
insert into Guests
values ('Softy16', 'ewanrecquignies@gmail.com','Michel','Ewan','2004-11-12', 'eh',true,false,true,false),
       ('OptimusPrime3000', 'optimus@gmail.com','Prime','Optimus','2004-11-12', 'eh',True,false,true,false),
       ('BumbleBee3000', 'bumble@gmail.com','Bee','Bumble','2004-11-12', 'eh',True,false,true,false),
       ('Kirby', '1@gmail.com','Faes','Hugo','2004-11-12', 'eh',True,false,true,false),
       ('TaGueuleThomas', '2@gmail.com','Meriaux','Thomas','2004-11-12', 'eh',false,false,true,false),
       ('FireWolf', '3@gmail.com','Hostelart','Anthony','2004-11-12', 'eh',true,true,true,false),
       ('Membre', '4@gmail.com','Hostelart','Anthony','2004-11-12', 'eh',false,false,true,false);

/* renvoie les joueurs selon l'équipe */
select *
from Guests
where isPlayer = true and Team = '/*TeamName*/';

/* renvoie les équipes */
select *
from team;

/* renvoie les membres en passe de devenir joueur */
select *
from Guests
where isRegistered = false;

/* renvoie TOUS les guests (membres, tentant de s'inscrire, admin, joueurs) */
select username, Team, isPlayer, isAdmin, isRegistered
from Guests;

delete from Guests
where username = 'ADELETE';

select *
from articles
order by datePublication;

SELECT * FROM Guests WHERE Team is null;

insert into Team values ('lolTeam',0,0,0),('t1',0,0,0),('t2',0,0,0);
insert into Capitain values ('FireWolf','lolTeam');
insert into Capitain values ('OptimusPrime3000','t1');
insert into Capitain values ('Softy16','t2');

update Guests set Team = 'lolTeam' WHERE username='FireWolf'  ;
update Guests set Team = 'lolTeam' WHERE username='TaGueuleThomas';
update Guests set Team = 't1' WHERE username='OptimusPrime3000';
update Guests set Team = 't1' WHERE username='BumbleBee3000';
update Guests set Team = 't2' WHERE username='Softy16';
update Guests set Team = 't2' WHERE username='Kirby';



insert into Match values (DEFAULT,'lolTeam','t1',3,1,2,null,false);
insert into Match values (DEFAULT,'lolTeam','t2',null,0,0,null,null);
insert into Match values (DEFAULT,'t1','t2',1,2,1,null,false);

insert into bet values('FireWolf',1,3);
insert into bet values('OptimusPrime3000',1,5);

insert into bet values('OptimusPrime3000',3,1);
insert into bet values('Softy16',3,5);

SELECT * FROM Match ORDER BY idmatch