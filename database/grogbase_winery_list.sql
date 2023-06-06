CREATE VIEW `winery_list` AS
    SELECT 
        `wineries`.`winery_id` AS `winery_id`,
        `wineries`.`name` AS `name`,
        `wineries`.`description` AS `description`,
        `wineries`.`established` AS `established`,
        `wineries`.`location` AS `location`,
        `wineries`.`region` AS `region`,
        `wineries`.`country` AS `country`,
        `wineries`.`website` AS `website`,
        `wineries`.`manager_id` AS `manager_id`,
        `R`.`rating_avg` AS `rating_avg`
    FROM
        (`wineries`
        LEFT JOIN (SELECT 
            `reviews_winery`.`winery_id` AS `winery_id`,
                ROUND(AVG(`reviews_winery`.`points`), 2) AS `rating_avg`
        FROM
            `reviews_winery`
        GROUP BY `reviews_winery`.`winery_id`) `R` ON (`wineries`.`winery_id` = `R`.`winery_id`))
