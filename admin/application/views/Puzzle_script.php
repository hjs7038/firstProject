<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script>
var TILE_CNT_X = 3;
var TILE_CNT_Y = 3;
var TILE_W = 0;
var TILE_H = 0;
var tiles = [];
var selectIdx = 0;
var bgCvs = null;
var bgCtx = null;
var objCvs = null;
var objCtx = null;
var txtCvs = null;
var txtCtx = null;
var complete = false;

var Tile = function() {
    this.x = 0;
    this.y = 0;
    this.originIdx = 0;
};

function Init() {
    // bg
    bgCvs = document.getElementById("bg");
    bgCtx = bgCvs.getContext("2d");

    var bgImage = new Image();
    bgImage.src = "https://i.imgur.com/2PBLK.jpg";
    bgImage.onload = function()
    {
        bgCtx.drawImage(bgImage, 0, 0, bgCvs.width, bgCvs.height);
    }

    // obj
    objCvs = document.getElementById("obj");
    objCtx = objCvs.getContext("2d");

    txtCvs = document.getElementById("txt");
    txtCtx = txtCvs.getContext("2d");

    TILE_W = bgCvs.width / TILE_CNT_X;
    TILE_H = bgCvs.height / TILE_CNT_Y;

    // init tiles
    for(var y = 0; y < TILE_CNT_Y; ++y) {
        for(var x = 0; x < TILE_CNT_X; ++x) {
        var tile = new Tile();
        tile.x = x * TILE_W;
        tile.y = y * TILE_H;
        tile.originIdx = tiles.length;
        tiles.push(tile);
        }
    }

    selectIdx = tiles.length-1;
    ShuffleTiles(tiles, 3000);

    setInterval(function(){
        // check complete
        for(var i in tiles) {
            if(tiles[i].originIdx != i) {
            break;
            }
            if(i == tiles.length-1) {
            complete = true;
            }
        }

        // render
        if(complete) {
            objCtx.drawImage(bgCvs, 0, 0, objCvs.width, objCvs.height);
        }
        else {
            objCtx.clearRect(0, 0, objCvs.width, objCvs.height);
            txtCtx.clearRect(0, 0, txtCvs.width, txtCvs.height);
            for(var i in tiles){
            if(tiles[i].originIdx == tiles.length-1) {
                continue;
            }
            objCtx.drawImage(bgCvs,
                parseInt(tiles[i].originIdx % TILE_CNT_X) * TILE_W,
                parseInt(tiles[i].originIdx / TILE_CNT_X) * TILE_H,
                TILE_W, TILE_H, tiles[i].x, tiles[i].y, TILE_W, TILE_H);

            objCtx.strokeRect(tiles[i].x, tiles[i].y, TILE_W, TILE_H);
            /*
            txtCtx.textBaseline = "top";
            txtCtx.font = "bold 15px 궁서";
            txtCtx.fillText("(" + i + ", " + tiles[i].originIdx + ")", tiles[i].x + TILE_W * 0.3, tiles[i].y);
            */
            }
        }
    }, 33);
}

function Random(min, max) {
    var num = Math.random() + Math.random();
    return (min + num * (max - min)) * 0.5;
}

function SwapTile(tiles, idx1, idx2) {
    var temp = tiles[idx1].originIdx;
    tiles[idx1].originIdx = tiles[idx2].originIdx;
    tiles[idx2].originIdx = temp;
}

function ShuffleTiles(tiles, count) {
    debugger;
    for(var i = 0; i < count; ++i) {
        var ran = parseInt(Random(0, 12) + Random(0, 12)) % 4;
        switch(ran) {
            case 0: {
                selectIdx = MoveUpTile(tiles, selectIdx);
            }
            break;
            case 1: {
                selectIdx = MoveDownTile(tiles, selectIdx);
            }
            break;
            case 2: {
                selectIdx = MoveLeftTile(tiles, selectIdx);
            }
            break;
            case 3: {
                selectIdx = MoveRightTile(tiles, selectIdx);
            }
            break;
        }
    }
}

function MoveTile(event) {
    var e = event || window.event;
    var keyCode = e.keyCode || e.which;

    switch(keyCode) {
        case 'W'.charCodeAt(0): {
            selectIdx = MoveDownTile(tiles, selectIdx);
        }
        break;
        case 'S'.charCodeAt(0): {
            selectIdx = MoveUpTile(tiles, selectIdx);
        }
        break;
        case 'A'.charCodeAt(0): {
            selectIdx = MoveRightTile(tiles, selectIdx);
        }
        break;
        case 'D'.charCodeAt(0): {
            selectIdx = MoveLeftTile(tiles, selectIdx);
        }
        break;
    }
}

function MoveUpTile(tiles, idx) {
    var result = idx - TILE_CNT_X;
    if(0 <= result) {
        SwapTile(tiles, result, idx);
        return result;
    }

    return idx;
}
function MoveDownTile(tiles, idx) {
    var result = idx + TILE_CNT_X;
    if(result < tiles.length) {
        SwapTile(tiles, result, idx);
        return result;
    }

    return idx;
}
function MoveLeftTile(tiles, idx) {
    var result = idx - 1;
    if(idx % TILE_CNT_X != 0) {
        SwapTile(tiles, result, idx);
        return result;
    }

    return idx;
}
function MoveRightTile(tiles, idx) {
    var result = idx + 1;
    if(result % TILE_CNT_X != 0) {
        SwapTile(tiles, result, idx);
        return result;
    }

    return idx;
}

</script>