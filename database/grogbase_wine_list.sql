CREATE VIEW `wine_list` AS
    SELECT 
        `wines`.`wine_id` AS `wine_id`,
        `wines`.`name` AS `name`,
        `wines`.`description` AS `description`,
        `wines`.`type` AS `type`,
        `wines`.`year` AS `year`,
        `wines`.`price` AS `price`,
        `wines`.`winery` AS `winery`,
        `R`.`rating_avg` AS `rating_avg`
    FROM
        (`wines`
        LEFT JOIN (SELECT 
            `reviews_wine`.`wine_id` AS `wine_id`,
                ROUND(AVG(`reviews_wine`.`points`), 2) AS `rating_avg`
        FROM
            `reviews_wine`
        GROUP BY `reviews_wine`.`wine_id`) `R` ON (`wines`.`wine_id` = `R`.`wine_id`))
