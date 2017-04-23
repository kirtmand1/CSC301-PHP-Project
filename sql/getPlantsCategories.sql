SELECT plant_categories.sku, p_categories.categoryid, p_categories.name
FROM plant_categories
JOIN p_categories on plant_categories.categoryid = p_categories.categoryid;