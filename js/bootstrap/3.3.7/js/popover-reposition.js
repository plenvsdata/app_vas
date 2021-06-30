$(function () {
    $.fn.popover.Constructor.prototype.reposition = function () {
        var $tip = this.tip();
        var autoPlace = true;

        var placement = typeof this.options.placement === 'function' ? this.options.placement.call(this, $tip[0], this.$element[0]) : this.options.placement;

        var pos = this.getPosition();
        var actualWidth = $tip[0].offsetWidth;
        var actualHeight = $tip[0].offsetHeight;

        if (autoPlace) {
            var orgPlacement = placement;
            var viewportDim = this.getPosition(this.$viewport);

            placement = placement === 'bottom' &&
            pos.bottom + actualHeight > viewportDim.bottom ? 'top' : placement === 'top' &&
            pos.top - actualHeight < viewportDim.top ? 'bottom' : placement === 'right' &&
            pos.right + actualWidth > viewportDim.width ? 'left' : placement === 'left' &&
            pos.left - actualWidth < viewportDim.left ? 'right' : placement;

            $tip
                .removeClass(orgPlacement)
                .addClass(placement);
        }

        var calculatedOffset = this.getCalculatedOffset(placement, pos, actualWidth, actualHeight);

        this.applyPlacement(calculatedOffset, placement);
    }
});