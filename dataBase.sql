Drop table if exists Guests, Team, Capitain, Match, Articles, Inscription, Run, Old_Tournament, Request, bet cascade;

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
                        Team text references Team
);

create table Request (
                         username text unique not null,
                         isPlayerAsk boolean not null,
                         Team text references Team,
                         primary key (username, Team)
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
                     idRun serial not null primary key,
                     title text not null,
                     image_data text not null,
                     starterPoint text not null,
                     finalPoint text not null,
                     orderRun int not null,
                     maxBet int not null check (maxBet>=0)
);

create table Match (
                       idMatch serial not null primary key,
                       attack text references Team,
                       defend text references team,
                       betTeamKept int,
                       goal int check(goal >= 0 and goal <= 5),
                       annee int not null,
                       idRun serial not null references run,
                       penal boolean not null,
                       contest boolean,
                       countAttack int,
                       countDefend int,
                       countMoves int,
                       check((not penal and countAttack IS NULL and countDefend IS NULL) or goal = 0)
);

create table bet(
                    username text not null references Guests,
                    idmatch int not null references Match,
                    betcap int,
                    primary key(username,idmatch)
);

create table Old_Tournament(
                               Edition date,
                               Classement int check(classement>0),
                               Team text not null,
                               primary key (Edition, Classement)
);

create table Inscription (
    open boolean unique not null primary key
);

insert into Inscription
values (true);


/* Jeu de test (Mot de passe Hashé par défaut: N1nt3nd0# )*/
insert into Guests
values ('Softy16', 'ewanrecquignies@gmail.com','Michel','Ewan','2004-11-12', '$2y$10$kvQreEw6k1KF6b.rVj3gheT4fOGKnCh2t5KOHuUD/r3u6CL.aO7/C',true,true,true,false),
       ('OptimusPrime3000', 'optimus@gmail.com','Prime','Optimus','2004-11-12', '$2y$10$kvQreEw6k1KF6b.rVj3gheT4fOGKnCh2t5KOHuUD/r3u6CL.aO7/C',True,false,true,false),
       ('Kirby', '1@gmail.com','Faes','Hugo','2004-11-12', '$2y$10$kvQreEw6k1KF6b.rVj3gheT4fOGKnCh2t5KOHuUD/r3u6CL.aO7/C',True,false,true,true),
       ('TaGueuleThomas', '2@gmail.com','Meriaux','Thomas','2004-11-12', '$2y$10$kvQreEw6k1KF6b.rVj3gheT4fOGKnCh2t5KOHuUD/r3u6CL.aO7/C',false,false,true,false),
       ('Valider', '3@gmail.com','Hostelart','Anthony','2004-11-12', '$2y$10$kvQreEw6k1KF6b.rVj3gheT4fOGKnCh2t5KOHuUD/r3u6CL.aO7/C',false,false,false,false),
       ('ADELETE', '4@gmail.com','Hostelart','Anthony','2004-11-12', '$2y$10$kvQreEw6k1KF6b.rVj3gheT4fOGKnCh2t5KOHuUD/r3u6CL.aO7/C',false,false,false,false);

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
