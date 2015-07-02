

function generate(newConfig) {
	var orgConfig = {
		text        : 'message',
		type        : 'alert',
		dismissQueue: true,
		timeout     : 2000,
		closeWith   : ['timeout'],
		layout      : 'topCenter',
		theme       : 'defaultTheme',
		maxVisible  : 10
	};
	var config = $.extend({}, orgConfig, newConfig);
	var n = noty(config);
	console.log('html: ' + n.options.id);
}

function addTableTr(obj, selector) {
	$(selector).clone(true).css('display', 'table-row').removeClass('modelTr').insertAfter($(obj).parents('tr:eq(0)'));
}

function deleteTableTr(obj) {
	$(obj).parents('tr:eq(0)').remove();
}

if (!String.prototype.repeat) {
  String.prototype.repeat = function(count) {
    'use strict';
    if (this == null) {
      throw new TypeError('can\'t convert ' + this + ' to object');
    }
    var str = '' + this;
    count = +count;
    if (count != count) {
      count = 0;
    }
    if (count < 0) {
      throw new RangeError('repeat count must be non-negative');
    }
    if (count == Infinity) {
      throw new RangeError('repeat count must be less than infinity');
    }
    count = Math.floor(count);
    if (str.length == 0 || count == 0) {
      return '';
    }
    // Ensuring count is a 31-bit integer allows us to heavily optimize the
    // main part. But anyway, most current (August 2014) browsers can't handle
    // strings 1 << 28 chars or longer, so:
    if (str.length * count >= 1 << 28) {
      throw new RangeError('repeat count must not overflow maximum string size');
    }
    var rpt = '';
    for (;;) {
      if ((count & 1) == 1) {
        rpt += str;
      }
      count >>>= 1;
      if (count == 0) {
        break;
      }
      str += str;
    }
    return rpt;
  }
}