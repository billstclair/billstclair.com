# The Blessings of Obscurity

I almost titled this piece, "The Curse of Obscurity", but I'm trying to see the positive... trying... Well, I try my own patience quite often.

I have a habit of being really good at doing obscure things. I could probably be just as good at doing more popular things, and I would likely profit more, but somehow I like obscure things better.

<center>
![Not Secret Agent Man](https://billstclair.com/steemit/obscurity/the-prisoner.jpg)
</center>

I spent much of the last two days working on [wp-emember-auth](https://github.com/billstclair/wp-emember-auth), a plugin for [Simple Machines Forum](http://www.simplemachines.org/) (SMF) that uses the authorization cookie and database for the WordPress [WP eMember](https://www.tipsandtricks-hq.com/wordpress-emember-easy-to-use-wordpress-membership-plugin-1706) plugin to auto-create an account and authorize login into SMF. I've been managing SMF installations for years, and have some small experience with [WordPress](https://wordpress.org/), but I had never heard of the WP eMember plugin until very recently, when a long-time efriend started using it on her paywalled web site (still in beta, so I won't link to it). wp-emember-auth will save people from having to create an account on both the WordPress site and the SMF forum.

PHP gets a  bad rap in the programming community. Sort of like Perl. Both suffer from large amounts of code written by not-so-great programmers. The code works, and both are quick ways to implement small web sites, but reliance on global variables still dominates, even though both have ways to insulate yourself from that today. I LIKE PHP. If you're careful, you can write good code in it. Perl can also be beautiful. Witness [Patrick Choreff's Loom](https://github.com/chkoreff/Loom/tree/master/code).

Obscure thing. Very few people, other than my friend will use it. She's paying me a little bit, but nowhere near my free market programming rates. But I really wanted to do it, and derived great enjoyment.

I've spent over half of the past thirty-eight years writing mostly [Lisp](http://clozure.com/) for a living. For another nine years, I wrote [Progress 4GL](http://progress4gl.com/) and [Java](https://www.java.com/). You've probably heard of Lisp and Java, but even I had never heard of Progress, until I interviewed at and was hired by a company that uses it as a basis for an accounting and job costing system for large construction companies.

For the past ten years, I've been working mostly at home writing Lisp for contract jobs. That contract market has largely dried up, so I was laid off a year ago as a full-time employee, but I've managed, with a little financial help from my mom (she's 86, I'm 60), to pay the bills on hourly work through the same company.

When I was first laid off, thinking about what to do next, I investigated [Erlang](https://www.erlang.org/), which led to [Elixir](http://elixir-lang.org/). Both are really efficient at huge, distributed systems. Both are obscure. I had heard of Erlang before I started investigating, but had never looked at it in detail. Fell in love immediately. Finally a language that erases the distinction between local and remote interprocess communication, except for communication latency. Finally a language where it is impossible to shoot yourself in the foot with multi-threaded access to global state, because there IS no global state; program state is immutable. Finally a garbage-collected language where garbage collection is guaranteed to be really fast. And then I found Elixir. Ruby that scales, big. All of Erlang's benefits, since it runs on the Erlang virtual machine, plus macros, and a much nicer syntax. Plus the [Phoenix web framework](http://www.phoenixframework.org/) very similar to [Ruby on Rails](http://rubyonrails.org/), except it's bloody fast. And obscure. But not as obscure as Lisp, or Progress 4GL.

One thing I learned going to parties as a froshling at MIT (in 1974) is to never talk shop with people who don't study your field. Each technical field has its own technical language, and people not in that field won't understand what you're talking about. I violated that in the previous paragraph. If you don't program computers, and even many who do, your eyes likely glazed over long before the paragraph was through.
