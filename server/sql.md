# 创建全局查询试图 sql 语句

```mysql
CREATE VIEW t_data_search AS
SELECT *
FROM (SELECT id as uid, title, image, 'article' as data_type, create_time as publish_time
      FROM t_article as t_article
      UNION ALL
      SELECT uid, title, image, 'exam_library' as data_type, create_time as publish_time
      FROM t_tenant_exam_library as t_tenant_exam_library
      UNION ALL
      SELECT uid, title, image, 'resource' as data_type, create_time as publish_time
      FROM t_tenant_resource as t_tenant_resource) AS t_data_search;
```