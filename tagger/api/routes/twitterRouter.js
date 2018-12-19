var express = require('express');
var Twitter = require('../models/tweetModel');
const tweetRouter = express.Router();

tweetRouter.route('/')
  .get((req,res) => {
    Twitter.find({}, (err, users) =>{
      res.json(users)
    })
  })
  .post((req, res) => {
    let user = new User(req.body);
    user.save()
    res.status(201).send(user)
  })
  .put((req, res) => {
    Twitter.updateMany({_id: {$in: req.body.ids}}, {tags: req.body.tags}, (err, doc) => {
      if (err) {
        res.status(500).send(err)
      }
      res.json(doc)
    })
  });

tweetRouter.route('/search')
  .post((req, res) => {
    Twitter.count({tweet: {$regex: req.body.query}}, (err,count) => {
      if (err) {
        res.status(500).send(err)
      }
      var totalRows = count
      Twitter.find({tweet: {$regex: req.body.query}},'tweet lemas tags',{skip: req.body.limit * (req.body.pag - 1), limit: req.body.limit} ,(err, tweets)=> {
        if (err) {
          res.status(500).send(err)
        }
        res.json({
          totalRows: totalRows,
          rows: tweets})
      })
    })
  })

module.exports = tweetRouter;
