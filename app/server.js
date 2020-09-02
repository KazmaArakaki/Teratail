const express = require("express");
const mysql = require("mysql");

const app = express();

app.set("view engine", "ejs");

const connection = mysql.createConnection({
  host: "mysql-server",
  user: "teratail",
  password: "password",
  database: "teratail"
});

connection.on("error", (error) => {
  console.error({ error });
});

connection.connect((error) => {
  if (error) {
    connection.end();

    throw error;
  }
});

app.get("/", (req, res) => {
  console.log({
    query: "GET /",
    params: req.params,
  });

  connection.query({
    sql: `
      SELECT * FROM vegetables
    `,
  }, (error, results) => {
    console.log({ results });

    res.render("index.ejs", {
      vegetables: results,
    });
  });
});

app.get("/delete/:id", (req, res) => {
  console.log({
    query: "GET /delete/:id",
    params: req.params,
  });

  connection.query({
    sql: `
      SELECT * FROM vegetables
        WHERE (
          id=?
        )
        LIMIT 1
    `,
    values: [
      req.params.id,
    ],
  }, (error, results) => {
    console.log({ results });

    if (results.length === 0) {
      return res.status(404).send();
    }

    res.render("delete.ejs", {
      vegetable: results[0],
    });
  });
});

app.post("/delete/:id", (req, res) => {
  console.log({
    query: "POST /delete/:id",
    params: req.params,
  });

  connection.query({
    sql: `
      DELETE FROM vegetables
        WHERE (
          id=?
        )
    `,
    values: [
      req.params.id,
    ],
  }, (error, results) => {
    console.log({ results });

    res.redirect("/");
  });

});

app.listen(3000);

