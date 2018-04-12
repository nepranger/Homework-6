--Create a table to hold information on movies
DROP TABLE IF EXISTS movies;
  
CREATE TABLE movies(
    id INT AUTO_INCREMENT,
    title VARCHAR(120) NOT NULL,
    director VARCHAR(255) NOT NULL,
    reldate VARCHAR(255) NOT NULL,
    video VARCHAR(255),
    PRIMARY KEY (id)
                    );


--Insert some movies into the table
INSERT INTO movies (title, director, reldate, video) VALUES ("Apocalypse Now", "Francis Ford Coppola", "August 15, 1979", "<iframe src='https://www.youtube.com/embed/FTjG-Aux_yQ' frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>");
INSERT INTO movies (title, director, reldate, video) VALUES ("Interstellar", "Christoper Nolan", "October 26, 2014", "<iframe src='https://www.youtube.com/embed/Lm8p5rlrSkY' frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>");
INSERT INTO movies (title, director, reldate, video) VALUES ("Saving Private Ryan", "Steven Spielberg", "July 24, 1998", "<iframe src='https://www.youtube.com/embed/RYID71hYHzg' frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>");
INSERT INTO movies (title, director, reldate, video) VALUES ("The Dark Knight", "Christoper Nolan", "July 18, 2008", "<iframe src='https://www.youtube.com/embed/EXeTwQWrcwY' frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>");
INSERT INTO movies (title, director, reldate, video) VALUES ("No Country For Old Men", "The Coen Brothers", "November 9, 2007", "<iframe src='https://www.youtube.com/embed/38A__WT3-o0' frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>");
