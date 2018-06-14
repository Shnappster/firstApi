<?php
/**
 * @SWG\Swagger(
 *     basePath="",
 *     host="127.0.0.1:8000",
 *     schemes={"http"},
 *     @SWG\Info(
 *         version="1.0",
 *         title="My First Api",
 *         description = "",
 *         @SWG\Contact(name="A2-LAB", url="http://a2-lab.com/"),
 *     ),
 *     @SWG\Definition(
 *         definition="Error",
 *         required={"code", "message"},
 *         @SWG\Property(
 *             property="code",
 *             type="integer",
 *             format="int32"
 *         ),
 *         @SWG\Property(
 *             property="message",
 *             type="string"
 *         )
 *     ),
 *     @SWG\Tag(
 *         name="users",
 *         description="CRUD"
 *     ),
 * )
 */
