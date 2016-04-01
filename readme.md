# php poker (德州扑克)

[![Build Status](https://travis-ci.org/RryLee/phppoker.svg?branch=master)](https://travis-ci.org/RryLee/phppoker)

### Install

You can use `composer global require rry/phppoker` to install the game.

If you use **linux** or **osx**.

You should add ~/.config/composer/vendor/bin to your path

If windows,

Just add the bin to you path manually.

### Feature

- random game

Just check `phppoker random -h` to know the rule.

`phppoker random`

    Please wait...
    +----------+----------------+
    | Username | Hand           |
    +----------+----------------+
    | Libby    | A♥ 2♦ J♠ 4♦ Q♠ |
    | Velva    | 9♦ K♦ 5♣ K♥ K♥ |
    +----------+----------------+
    The results were as follows:
    Winner: Velva
    Three of a kind, oh year!

- start game (appoint you and your friends to start)

`phppoker start 2 Foo Bar`

    Although names not enough, i still execute the program, thanks me.
    Please wait...
    +----------+-----------------+
    | Username | Hand            |
    +----------+-----------------+
    | Foo      | 5♣ 3♠ K♠ 7♦ 8♥  |
    | Bar      | 9♠ J♣ 5♥ 7♠ 10♣ |
    +----------+-----------------+
    The results were as follows:
    Winner: Bar
    High card, i am so luck

### TEST

`phpunit` to test poker core code.

### Other

If you have some suggestion or find a bug, welcome to tell me.

### License

MIT
