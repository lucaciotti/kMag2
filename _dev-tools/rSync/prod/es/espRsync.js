var Rsync = require('rsync');
// var path = require('path');

// Build the command
var rsync = new Rsync()
    .shell('ssh')
    .delete ()
    .flags('avz')
    .set('exclude-from', '_dev-tools/excluderSync_prod')
    .source('/c/PROJECTS/kMag2/src/')
    .destination('ced@172.26.0.101:/var/www/html/kMag2/');

var rsyncPid = null;

var quitting = function () {
    if (rsyncPid) {
        rsyncPid.kill();
    }
    process.exit();
}
process.on("SIGINT", quitting); // run signal handler on CTRL-C
process.on("SIGTERM", quitting); // run signal handler on SIGTERM
process.on("exit", quitting); // run signal handler when main process exits

// console.log(rsync.command());

// execute with stream callbacks
var rsyncPid = rsync.execute(
    function (error, code, cmd) {
        if(error) console.log('ERROR:', error);
        if (cmd) console.log('All done executing! ', cmd);
    }, function (data) {
        // do things like parse progress
        console.log(data.toString('utf-8'));
    }, function (data) {
        console.log(data);
        // do things like parse error output
    }
);

module.exports = {
    execRsync: rsyncPid
};