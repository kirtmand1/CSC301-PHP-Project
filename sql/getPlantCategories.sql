SELECT *
FROM plant_categories
JOIN p_categories on plant_categories.categoryid = p_categories.categoryid
WHERE sku = :sku