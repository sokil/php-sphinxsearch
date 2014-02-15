drop table if exists posts;
create table posts
(
    id int not null primary key auto_increment,
    user_id int,
    post_text text
);

insert into posts values (11, 1, 'If you can keep your head when all about you
Are losing theirs and blaming it on you,
If you can trust yourself when all men doubt you,
But make allowance for their doubting too');

insert into posts values (12, 1, 'If you can wait and not be tired by waiting,
Or being lied about, don\'t deal in lies,
Or being hated, don\'t give way to hating,
And yet don\'t look too good, nor talk too wise');

insert into posts values (13, 2, 'If you can dream - and not make dreams your master;
If you can think - and not make thoughts your aim;
If you can meet with Triumph and Disaster
And treat those two impostors just the same;');

drop table if exists comments;
create table comments
(
    id int not null primary key auto_increment,
    user_id int,
    post_id int,
    comment_text text
);

insert into comments values (21, 1, 1, 'If you can bear to hear the truth you\'ve spoken
Twisted by knaves to make a trap for fools,
Or watch the things you gave your life to broken,
And stoop and build \'em up with wornout tools');

insert into comments values (22, 2, 1, 'If you can bear to hear the truth you\'ve spoken
Twisted by knaves to make a trap for fools,
Or watch the things you gave your life to broken,
And stoop and build \'em up with wornout tools');

insert into comments values (23, 2, 2, 'If you can make one heap of all your winnings
And risk it on one turn of pitch-and-toss,
And lose, and start again at your beginnings
And never breathe a word about your loss;');