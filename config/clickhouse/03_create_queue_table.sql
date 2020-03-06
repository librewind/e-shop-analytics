CREATE TABLE eshop.queue (
    date Date,
    customer_id UInt32,
    customer_first_name String,
    customer_last_name String,
    customer_date_of_birth Date,
    product_id UInt32,
    product_sku String,
    product_name String,
    quantity UInt32,
    net_price Float32,
    discount_price Float32,
    promotion_id UInt32,
    promotion_name String
)
ENGINE = Kafka('e-shop-analytics-kafka:9092', 'fact_sales', 'group1', 'JSONEachRow');