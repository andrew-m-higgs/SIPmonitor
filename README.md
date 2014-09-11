SIPmonitor
==========

SIPmonitor is an open source gui using VoIPmonitor as the backend. It
was originally forked from VoipMonitor Free GUI but has since been
considerably changed.

It is beginning to become useful although some things feel hackish and
can possibly be done more elegantly. The dashboard at the moment is
just a dump from asterisk's 'sip show registry' and 'iax2 show
registry'. Active calls has 'sip show channelstats' and 'iax2 show
netstats' tacked on at the bottom. This tacked on data is not being
recorded to the database and is purely for display.
