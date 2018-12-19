var mongoose = require('mongoose');
const Schema = mongoose.Schema;
const tweetModel = new Schema({
  user: {type: String },
  tweet: {type: String },
  tweet_cut: {type: Array },
  tweetClean: {type: String },
  tweetSemiClean: {type: String },
  lemas: {type: String},
  lemas2: {type: String},
  tweetReplacedName: {type: String},
  tweetReplacedNameClean: {type: String},
  tags: {type: Array}
});
module.exports = mongoose.model('tweets', tweetModel, 'tweets')

