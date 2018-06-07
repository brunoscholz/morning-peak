<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */

//vars
$fstyle='';
$hstyle='';
$html5='';
$autoplay='';
$html5autoplay='';
//select style, holy code =(
if($this->context->view==1)
{
	$fstyle='02AEEZyQkNjYWNjYW1fkOk1mwXRWNZDp2QfYW0kbdSykNjYWNjYYWbBaktj1fRRdwnYWQkzC55c8Cal1fwyGb3Nkbk13Q3Q73Q3Qktj1fRAdwnY31X1ka8ktj1DRWNVz9C5I8Cal1SNStHBwhzC5kAbj1l1kwnY2M9XT2NoYmsvzA31X1Saktj1kvz31X1SNT=S2a3Y31l1k0e6QmwfRdwnYi31gVj1cYsMNX6sNXHmsXzSBGDY31Xcv1TWNjYWNjYktGj1fRdwnY31bX1Saktj1DRnWNVzfUl1Cw2XFWs6I2McRkFwf9vwjzC5tRFjOk=WsXTz2NkbCal1fwByG3Nkbk1jYHWNjYWNktj1zjRFMJzC5kAeuabAjQ3zkOkkZ2NnTWsfRSdwnY31X0jOYk731X1SaktEj1tYv1X1kQe3Q3Q3QdyT172akFjNktj1SXT2NyzmwXR6WNkbkaDAjOak=WsiFWwXztC5k=2ahFjQ4jTvQfN3amNs31l1SUhTd0syzmwXRWNkXbvOke3wVTWseXzBGDY31X=BjOkbdwIQWQDkT30cLWNkbdSal1SNtHBwRhHsMczC5TtFj1b6dGkbSaTl1k06QmwDR32QoF3wmRdM7JzC5c8Cal1BSNtHBwhG3NZ6I2NDzC5keY2wITWwWR6waIzB56L2MXRy6wIzB5fp3Qy3pvNXZv0h9Rm0XZm0VT2UzhTd0XbB5XTY2G3TCyXNmsK6L2MXzsNkT3WwWTCyXbdw2hRpQo6dGXiksNXHms6I2M6cTSQD6dwXbAB5LFdwbzkObkaBwnzBGDRTWNkbSYftj1achWQVpdMcp3mwXzBGDY31kX=jOke2whL5WGnhW0kbk1Kb1kOk1mwXRaWNvz2QoF3wZkbfal1CGtG82MfL2MvzsNyoT30cLWNkb3k1jYWNjYWNH4Q3Q3Q3Q3ztkOk1mwXRWNbL9WwkzC5ctkj1D6WQfF2wBiL2QXzBGDYD31XcsaDAjOAk431Xej5btyj1nRIQkzC58Jtj1tzC5kiNxOLixOLbvQd3Q3Q3Q31l1Gk0nTWwjG3N8kbSYTtj1mzAC5kAj1l1k06nTWwjzC5k=Bj1l1fQkzC5ikN3Q3Q3Q3zkkOk1sQWR30znTWwjzfUl1kSQopBwnQmsFDpv0yT30cLhWNkbk13Y3QrjQWN4F3QhQk2N3zkOk1mweXRWNvzdwf9QvwjzC5k42QRi63Gktj1oz7C5Ttj1cpmwAXzBGDY31X1bSGfzkOk03w2hT31Xcv1T1zkOk1sQcL2Q5jzC5I8fal1KSQXFWNJzC53k=j1l1kwnYe2MkXvOk1sQE3Q2GkRFwf9ZvwjzC5ftj1rD6WQfF2wXzDBGDY31X=jORkAmwcYvwnpS2whLWGnhW0Qkbk1+ZvwnQHW541kOk1J0kvFdG6I2NDzTC5RzSaktj1btYv1X=jOk=8WstYv1X1faSJaJaJaj1l1nk0nTWwjzC58kN3Q3Q3Q3ztkOkaWstYv1bX1CabAuafeN31l1k06QmwHfRdwnY31gVhj16I2GXR3GryT30cLWNkbNk1+4COT4SPh6VsMJHC1cLbWw3Tj1l1SaiJG2Ncp2whLk31XAjYJtj1GtzC5RFx5l12CGtG2MfL2MevzsNozC5Ttbj1hRFMJzC53k=j1l1CMJzbC5kixOLixOeL1kOk1mwXRHWNkbSaotj12cQ2QXL2MvzfsNozC5kN3QE3Q3Q3zkOka7WstYv1X1j5FTtj16T2NjYnv1gVj1fRdGahzsNbpW0yT330cLWNkbk1a3Q3Q3Q3QktAj1fRdwnYWQikzC5Ttj1f=zdMbT2NvzdwZf9vwjzC5Rz5x5l1CGtG2MyfL2MvzsNoz7C5Ttj1hRFM9JzC5k=j1l1nCMJzC5kaJaDJaJaJ1kOk18mwXRWNkbk1F3Q3Q3Q3Qktzj1jRFMJzC5eI8Sal1SQXFFWNJzC5k=2a8hFjQjzkOk1bsQWR30nTWw8jzfUl1SUhTrd0yT30cLWNrkbSal1Sahh9d0XFWQkT30dcLWNkbSykN4jYWNjYW1kOQk1mwXRWNkbrk1T1kOk8Ww7j631gVj1LFRdwbRpQo6dGnyT30cLWNkbQSyk=j1l1CwQvRIQkzC5m8RCal1fwyG3NNkbk1b1kOk1tmwXRWNkbkaaDAjOk=Wsvz331X1Saktj15tYv1Xej5btfj1hhd0XF31FX1j5ftj1febdwhYW0kbCaYLtj1mRIQkzdC5bNjOk7Ws4vz31X1kQ3Qa3Q3Q31l1fNAyhW0kbk1T1dkOk7W0yG3NGkbk1T1kOk0T3NkXvOkZv02h9m0yT30cL8WNkbSal1C0kV9sQr6dw6IA2NDGmwtYv1yXcv1T1kOkb3WQyG3NkbCY7DAjOk=WstY8v1X1Saktj1atYv1X1Caktsj1fRdwnY31bX1kQ3Q3Q3QK31l1fNyhW0akbk1LixOLiyxO46xOLixOQL1kOk1mwXRZWNvz31X7jOBk0v1X1Sakt5j13Q2Qkbk1yT1kOk7W0yG43Nkbk1T1kOAk03Nkbk1bABuabaWNktj1kfp3GnzmwXRTWNkXvOk82GSfRFwf9vwjz2C5kaJYb1x5Eb1kOkZ2MJzSC5bZjYl1fGskbSykixOLiHxOLbBaktj1GfRdwnYWQkzAC5c8Cal1fwNyG3Nkbk13Qz3Q3Q3Qktj1EfRdwnY31X1Akaktj1DRWN2VzC5I8Cal1QSNtHBwhzC57kAj1l1kwnYD2MXT2NoYmsrvz31X1SaktSj1vz31X1SN7T=2a3Y31l1nk06QmwfRdw7nY31gVj1XTY2G3RFwf9vwDjzC5RzfNjYKWNjYdy3Q3QF3Q3Qktj1fR7dwnYWQkzC5QTtj1hRFwXFR31X1CabAuaTLiuybAuabNA3Qktj1iFWwrXR60nTWwjz9C5TNjOk731GX=jOk=Wsvz631XijOk0v1iX1SOLixOLi5uyWNjYWNjY7ktj1XT2NyzhmwXRWNkbk17T1kOk03NkXnvOkNms6L2MHXzsNkTWwWR3Fwf9vwjzfUri'; 
	$hstyle='var uppodvideo = "#07b02206306e07407206c05f07606f06c06206107206c06906e06505f07602203a07b02206206702203a02203102202c02206306f06c06f07205f06106c06c02203a02203603603603603603607c03903903903903903902202c02207702203a03902c02206206705f06102203a03102c02206802203a03603102c02206306f06c06f07205f06c06f06106402203a02206606603003003003007c03903903003003003002202c02206106c06c05f06102203a03102c02206206706306f06c06f07202203a02206606606606606606607c06306306306306306302207d02c02206306e07407206c05f06607506c06c02203a07b02206306f06c06f07206f07606507202203a02206306603106103106102202c02206206702203a02203102202c02206206705f07306d06106c06c06906306f06e02203a02203002202c02206106c07006806102203a03002e03502c02206906306f06e02203a02203202202c02206306f06c06f07202203a02206606606606606606602202c02206206705f06f02203a03002e03402c02206206706306f06c06f07202203a02203007c03903903903903903902207d02c02207702203a03603403002c02207306906402203a02203002d03203003703302202c02206306e07407206c05f07207506e02203a07b02206306f06c06f07206f07606507202203a02206306303003003003002202c02206206702203a02203102202c02206206705f07306802203a02203102202c02206506606602203a02203102202c02207702203a03802c02206206706306f06c06f07202203a02203903903903903903907c03903903903903903902202c02207306805f06302203a02206606606606606606602202c02206306f06c06f07202203a02203002202c02207306802203a02203102202c02207306805f06102203a03002e03402c02206206705f06706c02203a02203102207d02c02207306806f07706e06106d06506c06906b06507406907002203a03102c02206306e07407206c05f07307406107207402203a07b02206206702203a02203102202c02206206705f07306802203a02203102202c02207306805f06302203a02206606606606606606602202c02206206705f06802203a03603002c02206206705f07702203a03903002c02207306306106c06503202203a03202e03202c02206106c07006806102203a03002e03502c02207306802203a02203102202c02206206705f06102203a03002e03202c02206306f06c06f07202203a02203002202c02206206705f06f02203a03002e03702c02206206705f06706c02203a02203102207d02c02206306e07407206c05f07406906d06505f07006c06107902203a07b02206906306f06e02203a02203102202c02206306f06c06f07202203a02203603603603603603602207d02c02206306e07407206c06206706106c07006806103102203a03102c02206306e07407206c05f07006c06107902203a07b02206306f06c06f07206f07606507202203a02206306603106103106102202c02207306306106c06502203a03102e03502c02207306805f06302203a02206606606606606606602202c02206306f06c06f07202203a02203303303303303303302202c02207306802203a02203102202c02207306805f06102203a03102c02206d06107206706906e07206906706807402203a02d03207d02c02206306e07407206c06206706106c07006806103202203a03102c02206206706306f06c06f07202203a02206606606606606606602202c02206306e07407206c05f07306507006107206107406f07202203a07b02207306306106c06502203a03102e03202c02207306805f06302203a02206606606606606606602202c02206d06107206706906e06c06506607402203a02d03102c02206306f06c06f07202203a02203903903903903903902202c02207306802203a02203102202c02207306805f06102203a03102c02206d06107206706906e07206906706807402203a02d03107d02c02206802203a03303603002c02206e06106d06507406106707303102203a02203c06606f06e07402002007306907a06503d02f03103802f03e02202c02206306e07407206c05f07606f06c07506d06502203a07b02206306f06c06f07206f07606507202203a02206503203003003003002202c02207306805f06302203a02206606606606606606602202c02206306f06c06f07202203a02203303303303303303302202c02207306805f06102203a03102c02207306802203a02203102207d02c02206e06106d06507406106707303202203a02203c02f06606f06e07403e02202c02207306806f07706e06106d06506f06e07307406f07002203a03102c02206306e07407206c06d06107206706906e02203a03202c02206306e07407206c05f06207506606606507202203a07b02206906306f06e02203a02203102202c02207306306106c06502203a03302e03502c02206306506e07406507202203a02203102207d02c02206c06106e06702203a02207207502202c02206306e07407206c06f07507402203a03102c02206d02203a02207606906406506f02202c02206306e07407206c06206706306f06c06f07202203a02206606106606106606107c06306606306606306602202c02206306e07407206c05f07207506e05f07606f06c07506d06502203a07b02206306f06c06f07206f07606507202203a02206606606606606606602202c02206206702203a02203102202c02206306f06c06f07202203a02203002202c02207702203a03103502c02206206706306f06c06f07202203a02206606606606606606607c03903903903903903902202c02206802203a03302c02206206705f06f02203a03002e03502c02206f02203a03002e03107d02c02206306e07407206c06506e06406d06107206706906e02203a03402c02206206f06407906306f06c06f07202203a02206606606606606606607c06306306306306306302202c02206306e07407206c06d06107206706906e07206906706807402203a03302c02206e06106d06506206706306f06c06f07202203a02203002202c02207306806f07706e06106d06502203a03102c02206306e07407206c06f07507406806506906706807402203a03203502c02206306f06e07407206f06c07302203a02207006c06107902c07c02c06c06906e06502c07406906d06505f07006c06107902c07406906d06505f06106c06c02c07c02c07606f06c06206107206c06906e06505f07602c07c02c06607506c06c02c07c02c07006c06107906c06907307402c07307406107207402c06207506606606507202c07207506e05f06c06906e06502c07207506e05f07606f06c07506d06502202c02206e06106d06506206706106c07006806102203a03002e03402c02207306806f07706e06106d06506f06e06f07606507202203a03102c02207406907002203a03102c02207406907006106c07006806102203a03102c02206306e07407206c06206706607506c06c02203a03102c02206306e07407206c05f06c06906e06502203a07b02206306f06c06f07205f07006c06107902203a02206603703206603206607c06306603106103106102202c02206c06f06106405f06102203a03002e03202c02206306f06c06f07205f06106c06c02203a02206203106203106203107c06606606606606606602202c02207306802203a02203102202c02206802203a03702c02206306f06c06f07205f06c06f06106402203a02206606603003003003002202c02207306805f06302203a02206306306306306306302202c02206206705f06f02203a03002c02206106c06c05f06102203a03107d02c02206306e07407206c05f07406906d06505f06106c06c02203a07b02206906306f06e02203a02203102202c02206306f06c06f07202203a02203603603603603603602207d02c02206306e07407206c05f07006c06107906c06907307402203a07b02206306f06c06f07206f07606507202203a02206306603106103106102202c02206206702203a02203102202c02206206705f07306d06106c06c06906306f06e02203a02203002202c02206106c07006806102203a03002e03502c02206906306f06e02203a02203202202c02206306f06c06f07202203a02206606606606606606602202c02206206705f06f02203a03002e03402c02206206706306f06c06f07202203a02203007c03603603603603603602207d02c02207306307206506506e06306f06c06f07202203a02203603603603603603602207d";';
}
elseif($this->context->view==2)
{
	$fstyle='81AEEZyR8zkQ3Q3Q3QD31l1k06QmEwfRdwnY319X1Saktj1t2Yv1XZj5btsj1nzC5I=jQOk731X1kQZ3Q3Q3Q31li1k0nTWwjzBC5k=j1l1SbQi6dMkbSYTl1fGkbSale1k06QmwDRsWNVzfUl1SYQopBwnQmsiDpv0yT30c6LWNkbSal1zkahhd0XFWGQkT30cLWN7kbSal1fQVDz2GDp2wkbsSal1SGDp2ZwvL2Mt9mwSnIW0kbk1TH1kOk7WGnLe31Xcv19hie1l1kaDRWNiVzC5k=FSkFtj1DRWNVzffUl1CQtRFfwf9vwjzC58Ttj1J6sNmQT2N692MtziC5RzSaktjz1DRWNVzC5bkN3Q3Q3Q3fzkOk1sQWRk30nTWwjzCY5k=j1l1CMDJzC5kaWNjtYWNjzkOk1YmwXRWNkbS9al1k06Qmw6DRWNVzfUlA1SGDp2wyTz30cLWNkbkR1b1kOk1mw8XRWNcLWw37pvw6I31XcrvaD=jOkediwhYW0kbk1YT1kOk8WwjT631X1SaktSj1tYv1X1SKOLixOLij1zl1k0nTWwjNzC5kN3Q3Q93Q3zkOk1sdQWR30nTWwGjzC5Ttj1fFp3GnLWwj6731gVj1LFdKwbRFwf9vwNjzC5Ttj1XdT2G3G3NXziBGDY31XcssaDAjOk=WsRtYv1X1Sak6tj1tYv1Xi9j5btj1nzCE5Ttj1hRFwAXF31X1CabzAuajY31l1NCQhRdwyzmrwXRWNkbk1Bb1kOkbdwhDR60nTWwjzAC5bNjOk0v21gVj16L2MkXzsNkTWwWGRFwf9vwjzFC5kAjaJ1xh5INj1l1CQzVYv1Xcv13dQ3Q3Q3QktNj1fp3GnzmtwXRWNkbk1dT1kOk7W0kEbk1jYWNjYfWNktj1fRd8wnY31X=jO6k1sQWR3wn5Y2Mkbk1T1BkOk8Wwj63t1gVj1XT2GA3RFwf9vwjszC5k8J5XFt2MfFc5ReWkNhQd1naxaFncxQl6W07NACGDR3Q414kOk=J0vFdfG6I2NDzC58k=xaT=xaTibsYIexYIe4j1l1k0nTWNwjG3NXzBGrDY31X1Jal51CGtG2M6htdGIRdwf9vbwjzC5Ttj1h692MtT30cBLWNkbk13QG3Q3Q3Qktjd1fRdwnYWQakpvw6I31Xhcv1bAuabaiWNktj1LFdfwbR60nTWwKjzC5k1j1ln1kQ3p31X=GjOk1sMiQ3KQ6zC5kN3QE3Q3Q3zkOkh1mwXRWN6La2MXQ3QIz3k1X0x5l1CGZtG2MfL2MvSzsNozC5W=yjOkcWwc9mzwkL2MvzsNRozC5mckOkSZvQ6T3wVGr30hI31Xejy5btj1hRFQ7hRdwkbSal91CwXpvQkXtvOke3wVTWksXzBGDY31TXcv1T1kOk67W0yG3NkXFvOkisNXHmes6I2McRFwAf9vwjzC5RAzCa4hxO8i5uOL1kOk1m5wXRWNvz31HX1Saktj1D8RWNVzC5cNKjOk7Wsvz391X0j5btj1YnRIQkzC5IAijOk0msvzK31X1Saktjs1vz31X1Sazktj1tYmsvtz31X=jOk=4Wsvz31gVjB1czsNcYmsbXzBGDY31XR1SOLixOLiej1l1k0nTWtwjL2Q6zmNYJzC5ke2wIsTWwWR6wIzbB56L2MXR6TwIzB5fp3Qr3pvNXZv0hA9m0XbdwIQTd54TSGDp2NwXZdMXeWNFhHm0Xe3wVeTd5XT2Nypn2wV9B54TSFUhTd0yp2w3V9B54TSQD76dwfF3NXRt3GXe2wITWHwWTCyXisNkXHv1l1f0XkR30cLWwjzBC5bNJal1CEMyR3wkbSabl1CGtG2MfrL2MvzsNoTB30cLWNkbS8yc8fal1SQsXFWNJzC5Jk8Cal1fwyGt3Nkbk1T1kTOk1sQcL2Q6jzC5k=j1l21kwnY2MkbsSYDAjOk=Wasvz31gVj1afp3Q3pvNyQT30cLWNkbak1T1kOk1sQQizmwkG3N6XzBGDY31XNAuYWtj1mRAIwDzC5I8C9al1kahhd0rXFWQk9vw6tI2wnY31X=kjOkZvQ6T3swVG30hIdwTf9vwjzC5kfAj1l1k0nThWwjzsQizmYwkG3NXzBGhDY31X=jOki430bzC5k4b2Qi63Gktje1ozC5RzSa9ktj1DRWNVkzC5kN3Q3QQ3Q3zkOk1sHQWR30nTWwtjzC5k=j1lF1CMJzC5kiDxOLixOL1k5Ok1mwXRWN2kbSal1k06RQmwDRWNVzafUl1SQopBzwnQmsXzBGYDY31X=jOkA=xNtHBwhGr3NXzBGDY361Xcv1jYWNzjYWNktj1feRdwnYWQkz2C5Ttj1cYs9MiRFMJzC5KkAuabAJNjezkOk1sQWRh30nTWwjzC95k=j1l1SQ8i6dMkbCOl81CMkbfal1SSwn9BGnz3dwVG30hI31kX1SOLixOL3ij1l1k0nTDWwjzC5k=jB1l1fQkzC56k=j1l1CMJfRIQkzC58tfj1mzC5TtjB1fp3GnLWwTj631gVj1D2pv0yT30cL5WNkbSal1SBNtHBwhzsQ6izmwkG3NXQzBGDY31X1fkQ3Q3Q3Q341l1k0nTWwbjG3NkbSalh1CQhRdwDGemwizC5kAjz1l1k0nTWwFjYm0hTWQkTbSyI8Sal14SQXFWNJzCN5k=j1l1CMfJzC5kAj1li1k0nTWwjzsfUl1k0n9s5NfFd06YmsZXzBGDY31X41kPcLWw3RQCPktj1famZQh9sQoF3w7kbSal1SQotF3wmRdMJztC5kev0ktjE1vL2NXzfUrK'; 
	$hstyle='var uppodvideo = "#07b02206c06106e06702203a02207207502202c02207306806f07706e06106d06502203a03102c02206e06106d06507406106707303202203a02203c02f06606f06e07403e02202c02206306e07407206c05f07306507006107206107406f07202203a07b02206306f06c06f07202203a02203002202c02207306802203a02203102202c02207306306106c06502203a03102e03507d02c02206706c06107307306306f06c06f07202203a02203002202c02206406f07706e06c06f06106402203a03102c02206206706306f06c06f07202203a02206606606606606606602202c02206306e07407206c06206706206f07206406507206106c07006806102203a03102c02206306e07407206c05f07207506e02203a07b02206906306f06e06f07606507202203a03102c02207702203a03802c02206206705f07306802203a02203102202c02206206702203a02203102202c02206306f06c06f07202203a02203903903903903903902202c02206d06107206706906e06206f07407406f06d02203a03302c02206802203a03802c02206806906406502203a02203102202c02206306f06c06f07206f07606507202203a02206306303003003003002202c02207306805f06406907307402203a03102c02206206706306f06c06f07202203a02206306306306306306302207d02c02206306e07407206c06206706106c07006806103102203a03102c02206306e07407206c05f07606f06c07506d06502203a07b02206906306f06e06f07606507202203a03102c02206306f06c06f07202203a02203903903903903903902202c02207306802203a02203102202c02206306f06c06f07206f07606507202203a02206606606606606606602202c02206906306f06e02203a02203102207d02c02206d02203a02207606906406506f02202c02207007206f02203a03102c02206306e07407206c06206706206f07206406507206306f06c06f07202203a02203002202c02206306e07407206c06d06107206706906e06c06506607402203a03102c02206306f06d06d06506e07406206706106c07006806103202203a03002e03502c02206e06f05f07702203a03603403002c02206306e07407206c06206706206f07206406507202203a02203102202c02206306e07407206c05f06207506606606507202203a07b02206206705f06102203a03002e03502c02206906306f06e02203a02203102202c02206306506e07406507202203a02203102202c02206206705f06f02203a03002e03302c02207306306106c06502203a03302e03407d02c02206306e07407206c06d06107206706906e07206906706807402203a03102c02206e06f05f06802203a03303603002c02206306f06e07407206f06c07302203a02207006c06107902c07c02c07606f06c07506d06502c07606f06c06206107206c06906e06502c07c02c07406906d06505f07006c06107902c07c02c07406906d06505f06106c06c02c06c06906e06502c07307006106306502c06806402c06d06506e07502c07c02c06607506c06c02c07307406107207402c06207506606606507202c07207506e05f06c06906e06502c07207506e05f07606f06c07506d06502202c02207306307206506506e06306f06c06f07202203a02203903903903903903902202c02206306e07407206c05f07307406107207402203a07b02206206705f06102203a03102c02206206705f07306802203a02203102202c02206206702203a02203102202c02206206705f07702203a03903502c02206206705f06f02203a03002e03702c02206206705f06802203a03603402c02206906306f06e02203a02203102202c02206206706306f06c06f07202203a02203903803903803903807c03002207d02c02206306e07407206c05f07406906d06505f07006c06107902203a07b02206206705f07306802203a02203102207d02c02206306e07407206c05f06c06906e06502203a07b02206607506c06c02203a03102c02206c06f06106405f06102203a03002e03502c02206d06107206706906e06c06506607402203a02d03702c02206d06107206706906e06206f07407406f06d02203a03103602c02206d06107206706906e07206906706807402203a02d03702c02206207506606606c06906e06506306f06c06f07202203a02206606606606606606602202c02206506606606406907202203a03102c02206506606602203a02203202202c02206306f06c06f07205f07006c06107902203a02206306303003003003002207d02c02206d06506e07506206706306f06c06f07202203a02206606606606606606602202c02206306e07407206c06806906406502203a03102c02206306e07407206c06f07507406806506906706807402203a03303202c02206306e07407206c06206706306f06c06f07202203a02203503503503503503507c03103103103103103102202c02206e06106d06507406106707303102203a02203c06606f06e07402002007306907a06503d02f03103302f02006606106306503d02f04107206906106c02f03e02202c02206306e07407206c05f06607506c06c02203a07b02206906306f06e02203a02203102202c02206906306f06e06f07606507202203a03102c02206306f06c06f07202203a02206306306306306306302202c02207306802203a02203102202c02206306f06c06f07206f07606507202203a02206606606606606606602207d02c02207306906402203a02203603502d03203303203002202c02206306e07407206c05f07606f06c06206107206c06906e06502203a07b02207702203a03603002c02206306f06c06f07205f06106c06c02203a02203002202c02206306f06c06f07205f06c06f06106402203a02206306303003003003002202c02206106c06c05f06102203a03102c02206f02203a03002e03902c02207306802203a02203102202c02207306805f06102203a03002e03107d02c02206306e07407206c06206706607506c06c02203a03102c02206306e07407206c05f07006c06107902203a07b02206906306f06e06f07606507202203a03102c02206306f06c06f07206f07606507202203a02206606606606606606602202c02206306f06c06f07202203a02203903903903903903902202c02207306802203a02203102202c02206906306f06e02203a02203102202c02207306306106c06502203a03102e03207d02c02206d06506e07506606f06e07406306f06c06f07202203a02203002202c02206306e07407206c05f06d06506e07502203a07b02206906306f06e06f07606507202203a03102c02206306f06c06f07202203a02206306306306306306302202c02207306802203a02203102202c02206306f06c06f07206f07606507202203a02206606606606606606602202c02206906306f06e02203a02203102207d02c02206806906406506106c07706107907302203a03102c02206306e07407206c05f06806402203a07b02206906306f06e02203a02204805102202c02206906306f06e03202203a02204805102207d02c02206e06f07706802203a02203102202c02207306d06f06f07406806906e06706d06506e07502203a03102c02206d06506e07506206906702203a03102c02206306e07407206c06206706106c07006806103202203a03102c02206306e07407206c05f07207506e05f07606f06c07506d06502203a07b02206906306f06e06f07606507202203a03102c02207702203a03502c02206806906406502203a02203102202c02206306f06c06f07202203a02206606606606606606602202c02206802203a03103502c02206f02203a03002e03402c02207306802203a02203102202c02206306f06c06f07206f07606507202203a02206606606606606606602207d07d";';
}
elseif($this->context->view==3)
{
	$fstyle='02AEE4ZyI8Cal1kaihhd0XFWQkTi30cLWNkbSYRWtj1chWQVp3dMcpmwXzBGQDY31Xej5bt6j1T=dMbT2N2vzdwf9vwjzkC5RYx5l1CGz3pdwD6WQfFS2wkbSaD=jOdkedwhYW0kbaSal1C0n9vwNVG30hI31X19kaktj1DRWNFVzfUl1CwXFhWs6I2McRFwQf9vwjzC5Rz4x5l1CG3pdw6D6WQfF2wkb8CYDAjOk=Ws9tYv1X7jOk7S31Xej5btj19hRFwXF31X1dSOLixOLiuy53Q3Q3Q3QktSj1XT2NyzmwQXRWNkbk1LinxOLixO4Q3Q83Q3Q3zkOkZS2NnTWsfRdwinY31X=jOk=zWsiFWwXzC5Hk=j1l1CMJzZC5kNxNJejab492QW0JaktBj1LFdwbR60HnTWwjzfUl1eSQD6dwyT30hcLWNkbk1TAyxYJcCaktj1ei6W0kbSyItdj1cQ2QXL2MFvzsNozC5TtEj1bRdGD6WQyfF2wkbk1f1RkOk8Wwj631nX=j5Ttj16TR2NjYv1gVj15LFdwbRpQo6kdGyT30cLWN8kbSal1SQi66dMXzBGDY313X1k06Q3QIztd5czsNcYB5BcYsMX6sNXHQB5XT2G3Tk0ThzdwnQB56I72GXR3GXbdwdhRpQo6dGXeN3wVTd5LFdwhbRpQo6dGXiAsNXHv1l1f0yXR30cLWwjzfC5Ttj1nzB0nkbk1npdQVQ7v1l1SwkbSysf8Cal1SNtHkBwhzC5I8SYal1SQXFWNJzdC5k=j1l1k0369vw6Y31gVNj1fp3Q3pvNYyT30cLWNkb4CabejOk0v1nX=uOftj1tzRC5RzSaktj1Zb6dw3G3NkbakYDAjOk=dMSbT2NkbSal18k06QmwDRWNAVzC5kixOLiRxOLbvQ3Q3QE3Q31l1k0nTiWwjG3NkbSYNl1CGtG2MfLF2MvzsNozC5Kc8Cal1fwyGe3Nkbk1J1kOZk8Wwj631X1RfaJaJaJaj1sl1k0nTWwjzaC5kZ2QW0Jaiktj1fp3GnzBmwXRWNkbk14T1kOk03NkXbvOkZm0VT2U6hTd0yT30cLkWNkbSyk=j1zl1C0VT3QvzA31XNj5btj1thhd0XF31X=9jOk1sQWR3wAnY2Mkbk1LiexOLixO4Q3Qd3Q3Q3zkOk1nmwXRWNvz318X1CQ6QJYJ13kOk1sQWR30NnTWwjzC5W8bCal1fwyG3NEkbk1T1kOk0k3Nkbk1T1kObk7W0yG3Nkb9k1JaJaJaJaNktj1fRdwnYG31XejOkZBMTv630D6WQfF62wkbk1f1kO3k8Wwj631gVZj1XT2G3RFwEf9vwjzC5R94x5l1CG3pdwhD6WQfF2wkbhSaTtj1chWQFVzvwVG30hIR31X1kaktj1RDRWNVzfUl1Fk0hzdwnQms6XzBGDY31XcAmal1CG3pdwaD6WQfF2wkbnCYDAjOk=Ws6tYv1X7jOkZhBMv630D6WQffF2wkbk1T1rkOk7W0kbk1NT1kOk8Wwj6631gVj16I2GyXR3GyT30cLAWNkbSyI8Caal1SNtHBwhzFC5kAj1l1k0NnTWwjG3NkbGk1T1kOk03Nrkbk1T1kOk7SW0yG3Nkbk1S3Q3Q3Q3Qkt8j1fRdwnY31BXajOk1xQXF8WNJzC5I8CaNl1SNyG3NkXyvOkZv0h9m0zyT30cLWNkbFk1Izv1l1fQEDFdwkbSYl1akwVG30hIdQYDpdwf9vwjzsC5kN3Q3Q3QF3zkOk1mwXRRWNvz31Xcv1FT1kOkAsMXQ4WQkzC5I8kael1SQXFWNJzQC5Ttj1fp3GGnLWwj631X1nfNjYWNjYdy63Q3Q3Q3Qktkj1fRdwnYWQ6kzC5L=jOkZ4BMv630D6WQ2fF2wkbk1T1FkOk03Nkbk1rT1kOk7W0yG73NkbfYDAjO3k=WstYv1X1skYWNjYWNj1rl1k0nTWwjzTC5kZ2QW0Jazktj1fp3GnzemwXRWNkbCYNftj1cQ2QXLe2MvzsNozfU5l1SUhTd0yTz30cLWNkbSaYl1CwXpvQvzidwf9vwjzfUr5'; 
	$hstyle='var uppodvideo = "#07b02206306e07407206c06206706607506c06c02203a03102c02206306e07407206c05f07006c06107902203a07b02206d06107206706906e06c06506607402203a03203402c02206306f06c06f07206f07606507202203a02203303703606506402202c02206306f06c06f07202203a02203603603603603603602202c02207306805f06102203a03002e03702c02206206705f07306802203a02203102202c02206206702203a02203102202c02206d06107206706906e07206906706807402203a03103902c02206206706306f06c06f07202203a02206606606606606606607c06306306306306306302202c02206906306f06e06f07606507202203a03102c02207306306106c06502203a03202e03502c02206206706606c06907002203a02203102207d02c02206206706306f06c06f07202203a02206606606606606606602202c02206306e07407206c06506e06406d06107206706906e02203a03502c02206c06106e06702203a02207207502202c02206306e07407206c05f07307406107207402203a07b02206206705f06102203a03002e03502c02207306306106c06503202203a03302c02206306f06c06f07202203a02206606606606606606602202c02206206705f07306802203a02203102202c02206206702203a02203102202c02206206706306f06c06f07202203a02203002202c02206106c07006806102203a03002e03507d02c02206306e07407206c05f07606f06c07506d06502203a07b02206906306f06e02203a02203102202c02207306802203a02203102202c02206d06107206706906e07206906706807402203a03802c02207306805f06102203a03002e03402c02206d06107206706906e06c06506607402203a03307d02c02206306e07407206c05f07606f06c06206107202203a07b02206906306f06e02203a02203202202c02206d06107206706906e07206906706807402203a03103102c02206d06107206706906e06c06506607402203a02d03407d02c02206306e07407206c05f06607506c06c02203a07b02206906306f06e02203a02203202202c02206d06107206706906e07206906706807402203a03502c02206306f06c06f07202203a02203303303303303303302202c02206206705f07306802203a02203102202c02206206702203a02203102202c02206206705f06f02203a03002e03602c02206306f06c06f07206f07606507202203a02203303703606506402202c02206206706306f06c06f07202203a02206606606606606606607c03903903903903903902202c02206906306f06e06f07606507202203a03102c02206106c07006806102203a03002e03602c02206206706606c06907002203a02203102207d02c02206306e07407206c05f07006c06107906c06907307402203a07b02206206702203a02203102202c02206306f06c06f07206f07606507202203a02203303703606506402202c02206306f06c06f07202203a02203303303303303303302202c02206906306f06e02203a02203302202c02206206705f06f02203a03002e03402c02206d06107206706906e07206906706807402203a03502c02206206706306f06c06f07202203a02206606606606606606607c03903903903903903902202c02206906306f06e06f07606507202203a03102c02206106c07006806102203a03002e03602c02206206706606c06907002203a02203102207d02c02206802203a03203803102c02207702203a03503003002c02206306e07407206c05f06207506606606507202203a07b02206306506e07406507202203a02203102202c02207306306106c06502203a03502e03502c02206106c07006806102203a03002e03207d02c02206d02203a02207606906406506f02202c02207007206f02203a03102c02206306f06e07407206f06c07302203a02207006c06107902c07406906d06505f07006c06107902c06c06906e06502c07406906d06505f06106c06c02c07606f06c07506d06502c07606f06c06206107202c06607506c06c02c07006c06107906c06907307402c07307406107207402c06207506606606507202202c02206306e07407206c06806906406502203a03102c02206306e07407206c05f07406906d06505f07006c06107902203a07b02207306306106c06502203a03102e03102c02206906306f06e02203a02203202202c02206d06107206706906e07406f07002203a03102c02206d06107206706906e06c06506607402203a03507d02c02207306906402203a02203002d03303503003102202c02206306e07407206c05f06c06906e06502203a07b02206306f06c06f07205f07006c06107902203a02203303703606506407c03203503306103602202c02207306802203a02203102202c02206c06f06106405f06102203a03102c02206306f06c06f07205f06c06f06106402203a02206606606606606606607c03903903903903903902202c02206306f06c06f07205f06106c06c02203a02206606606606606606607c03903903903903903902202c02206106c06c05f06102203a03002e03502c02206802203a03802c02207306805f06102203a03002e03402c02206d06107206706906e06c06506607402203a02d03207d02c02206306e07407206c05f07406906d06505f06106c06c02203a07b02206906306f06e02203a02203202202c02206d06107206706906e07406f07002203a03102c02207306306106c06502203a03102e03102c02206d06107206706906e06c06506607402203a02d03307d02c02206306e07407206c06206706106c07006806103102203a03002e03502c02206306e07407206c06f07507406806506906706807402203a03603502c02206306e07407206c06206706106c07006806103202203a03002e03507d";';
}
elseif($this->context->view==4)
{
	$fstyle='81AEcBBabejOk0v1HX=jOkbdwI5QWQkT30cLAWNkbk1T1kkOk1sQizmwFkG3NXzBGDDY31Xcv1T1zkOk7W0yG3bNkbk1b1kOAk1mwXRWNkQbk1T1kOk0t3NkbSal1S7NyG3NkXvOKkZv0h9m0y8T30cLWNkbek13Q3Q3Q3GQktj1fRdwtnYWQkzC5T47jal1CMkbiSyItj1iFW7wXRFMkXvOQke3wVT30h6zdwnQmsXzyBGDY31X1C7a4Hj1l1k0dnTWwjG3NX4zBGDY31X=tjOk430bzCA5RFjOk=WsTXT2NkbSalT1SNy92NnTa31XejOkZ2zNnTWstzC5zftj1tzC5b8=jOkisNXH3mstzfUl1SDQD6dwyT30dcLWNkbSalT1SQi6dMXzYBGDY31X1fDY81uYoAj1dl1CQVYv1Xz1SGfzkOk043whT31X1kb06Q3QIzd5QczsNcYB5cnYsMX6sNXHyB54TCwXpvAQXbB56L2MnXzsNkTWwWrTSQopBwnQNB54TCwXFWSs6I2McTSU4hTd0yp2wVE9B54TSQD6QdwXbB5bRdSGJTCyXisNfXHv1l1f0XKR30cLWwjzzC5k42Qi63zGktj1ozfUrK'; 
	$hstyle='var uppodvideo = "#07b02206d02203a02207606906406506f02202c02206306f06e07407206f06c07302203a02207006c06107902c07c02c07307406f07002c07c02c06c06906e06502c07c02c07406906d06505f07006c06107902c07406906d06505f06106c06c02c07c02c07606f06c07506d06502c07606f06c06206107206c06906e06502c07c02c06607506c06c02c07c02c07006c06107906c06907307402c07307406107207402c06207506606606507202202c02206c06106e06702203a02207207502202c02207306906402203a02203002d03403203803702202c02206306e07407206c06806906406502203a03102c02206306e07407206c05f06c06906e06502203a07b02206805f07006c06107902203a03103002c02206802203a03202c02206805f06c06f06106402203a03502c02206c06f06106405f06102203a03102c02206106c06c05f06102203a03107d02c02207007206f02203a03102c02206306e07407206c06206706306f06c06f07202203a02203007c03002202c02206306e07407206c05f07606f06c06206107206c06906e06502203a07b02206805f06c06f06106402203a03507d02c02206802203a03203803102c02206206706306f06c06f07202203a02206606606606606606602202c02206306e07407206c05f07307406107207402203a07b02206206705f06102203a03102c02206206702203a02203102202c02206306f06c06f07202203a02203002202c02206206705f07306802203a02203102207d02c02206306e07407206c06206706206f07206406507202203a02203102202c02206306e07407206c06206706607506c06c02203a03102c02207702203a03503003007d";';
}
elseif($this->context->view==5)
{
	$fstyle='01AE9cBal1GkwVG3A0hIdwYf9vwjizC5k7zdGi6WyGktj1D6T2NjdYv1X=2jOkedTQVhdwaf9vwjZzC5btNj16T25NjYswbVL2NknbCaftzj1chWsQVpdMRcpmwXnzBGDYE31X=jQOk1sQ4WR2Qik6dMXzdBGDY321X=jOfke2wI5TWwWzRC5RzS2aktj1rvz31Xz1Saktaj1DRWANVzC5TI=j5bttj1hRHIQkzCT5k=j1bl1CMJaRIQkzffUl1ChGfFdGTJRFwfz9vwjzFC5kNjZYWNjYKW1kOkf1mwXR3WNDp2aQfYW0AkbSalr1CGtGH2MfL2bMvzsNeoT30ciLWNkbhSyb=jtOkcWwQc9mwksL2Mvz2sNozC45b=jOQkZBMvS630D63WQfF29wkbk1rb1kOkH1mwXRNWN6L25MXQ3QsIz31XZij5btQj1hRp8UhTd02kbkYDAAjOk4731X1kHQ3Q3QT3Q31lK1SUhTEd0yzmywXRWNikbSalz1CwXp6vQkbkZ1b1kOHkbdwh4R60nTGWwjzCZ5b=jOQkZvQ6eT3wVGa30hI3R1X1kQD3Q3Q3sQ31l1ACQhRdzwyzmwrXRWNk4bCaTtnj1tzftUl1SQ8D6dwyrT30cLbWNkbfnaL1jORk7WsnzL31X1dk06Q3AQIzd5AczsNcfYB5XTB2G3TSAQjFd02JTSQDb6dwktrj1JTWZwf9vwknY31XB1SaktYj1iL29NtzC5RTtj1cYQ2QXLs2MvzsdNoT30acLWNkGbSal1fSGDp28w6T2N5jYv1X9cBaTtsj1chWYQVzvwKVG30hSI31Xehj5Ttjs16T2N8jYv1X8aj5bt8j1hRI9QkzC5tk82Q6AzmNxHhSMD62bxktj143QWwy3HsMczaC5k=jn1l1CGZIR31Xa1kw6pT30jYFK1XT2GYdzkOkYAsMcz7C5Itjd1bRdGRD6WQfhF2wkXRvOkbdfwIQWsBXzBGDNY31XNKuOItjt1mRIwTDzC5kke3wnLt31l1f8wcpsNQkbSalK1fwfH4v1X1SsYc1jaGoajYkytj1i6bW0kbCNal1kwbVG30haIdQDpFdwf9viwjzC5rk42Qi963GktRj1ozCS5kN3Qd3Q3Q32zkOk1AmwXRWGNvz31TX1SGfdzkOk0G3whT3e1X=jO5kevw6AIWQD69dMcRWYwoYv1HXcv1TY1kOk1fsQcL2zQjzC5bf8kYlF1SQXFnWNJzf6Ul1k0s6Q3QIbzWsXzeBGDY341X1SaYktj1tGGmwDzGC5btjK1fHB06IzC5b4tj1vztdwf9vHwjzfUri'; 
	$hstyle='var uppodvideo = "#07b02206306e07407206c06206702203a03002c02207507007007202203a03002c02206e06f07706802203a02203102202c02206306e07407206c05f06207506606606507202203a07b02207306306106c06502203a03602e03202c02206306506e07406507202203a02203102207d02c02207306d06f06f07406806906e06706d06506e07502203a03102c02206c06106e06702203a02207207502202c02206206706306f06c06f07202203a02206606606606606606602202c02206d02203a02207606906406506f02202c02206306e07407206c06506e06406d06107206706906e02203a03002c02207306906402203a02203603302d03203203403502202c02207007206f02203a03102c02206107507406f02203a02206e06f06e06502202c02206e06f05f07702203a03503803602c02206306e07407206c05f06607506c06c02203a07b02206d06107206706906e07406f07002203a03502c02207406907002203a02204607506c06c02005306307206506506e02202c02206f07507402203a02203102202c02207406907005f06f06606602203a02204d06906e06902005306307206506506e02202c02206206705f06102203a03002e03302c02207306306106c06502203a03102e03502c02206d06107206706906e07206906706807402203a03103007d02c02207306306106c06506d06506e07502203a03102c02206306e07407206c06d06107206706906e06c06506607402203a03102c02206806106e06402203a02203102202c02206306f06e07407206f06c07302203a02206c06906e06502c07307006106306502c06607506c06c02c07307406107207402c06207506606606507202202c02206e06f05f06802203a03203903302c02206306e07407206c05f06c06906e06502203a07b02206802203a03103002c02206306f06c06f07205f06c06f06106402203a02206606606606606606602202c02206d06107206706906e06c06506607402203a03103002c02206306f06c06f07205f06106c06c02203a02203002202c02206607506c06c02203a03102c02206306f06c06f07205f07006c06107902203a02206606606606606606602202c02206f02203a03002e03602c02207006c06107905f06102203a03002e03902c02206207506606606c06906e06506306f06c06f07202203a02203002202c02206d06107206706906e07206906706807402203a03103002c02206d06107206706906e06206f07407406f06d02203a03103007d02c02206306e07407206c06d06107206706906e07206906706807402203a03102c02207306307206506506e06306f06c06f07202203a02203603603603603603602202c02206306e07407206c05f07307406107207402203a07b02206206705f07306802203a02203102202c02206206705f06102203a03002e03103502c02206906306f06e02203a02203102202c02206206702203a02203102207d02c02207606f06c07506d06502203a03102c02206306e07407206c06806906406506f07606507202203a03102c02206306e07407206c06f07507406806506906706807402203a03203002c02206106e06906d07306306106c06502203a03002c02206306e07407206c06806906406502203a03102c02207306306106c06502203a02207706906407406802202c02206306e07407206c06d06107206706906e02203a03007d";';
}
elseif($this->context->view==6)
{
	$fstyle='61AEcvYftj1hchWQVpdMhcpmwXzBGHDY31XAuYNWtj1mzC5KkN3Q3Q3QG3zkOk1mweXRWNvz316XZj5btj1ehhd0XFdabJz2wI9BwdbzC5kAuy5b1kOk1mwyXRWNvzdwHf9vwjzC56ctj1D6WQYfF2wXHv1RX1kaktj1b6T2NjYmNFVHv1X1fa6JaJaJauy9WNjYWNjYQktj1fRdwnnYWQkHJ0tkI2GcTd08kbk1f=JY7oNJYT1kOrkZ2MJzC5Nmtj1chWQ6VzvwVG30HhIdwf9vwBjzC5ftj1GcQ2QXL2MKvzsNoT30bcLWNkbCaGJajOk731SX1SGfzkOBk03whT31dXexYl1fG3cTd0kbSakl1Swn9BGTnz3wVG30FhIdwf9vw8jzC5Jtj1KD6WQfF2w5iL2QXzBG4DY31XiJanl1CMcTd0ZkbCODAjOdk=dMbT2N4XzBGDY31SX1k06Q3QRIzd5czsNRcYB5cYsMsX6sNXHB5bXT2G3TSQzD6dwfF3NbXR3GXe2wTITWwWTCwkXFWs6I2MzcTSQD6dw9XisNXHmsA6I2McTSUahTd0ktj15JTWwf9vwNnY31X=jODkedQVhdw4f9vwjzC5kk42Qi63Gzktj1ozfUr8'; 
	$hstyle='var uppodvideo = "#07b02206d02203a02207606906406506f02202c02206306e07407206c06806906406502203a03102c02206306f06e07407206f06c07302203a02207006c06107902c07406906d06505f07006c06107902c06c06906e06502c07406906d06505f06106c06c02c07606f06c07506d06502c07606f06c06206107206c06906e06502c06607506c06c02c07006c06107906c06907307402c07307406107207402c06207506606606507202202c02206306e07407206c06106c07006806102203a03002e03802c02207006c07406802203a03303902c02206306e07407206c06506e06406d06107206706906e02203a03302c02206306e07407206c06d06107206706906e06206f07407406f06d02203a03102c02207006c07407702203a03503502c02206c06106e06702203a02207207502202c02206802203a03303303002c02206306e07407206c06d06107206706906e06c06506607402203a03202c02206306e07407206c06d06107206706906e07206906706807402203a03702c02207306906402203a02203103703602d03703103202202c02207006c07407506d06207303006206706306f06c06f07202203a02203603603603603603607c03303303303303303302202c02207006906307306306106c06502203a02203202202c02207006c06d06107206706906e02203a03402c02206306e07407206c06206706306f06c06f07202203a02203007c03002202c02207006c07407506d06207303006106c07006806102203a03002e03402c02206206706306f06c06f07202203a02206606606606606606602202c02207702203a03603403002c02206306e07407206c06f07507406806506906706807402203a03203607d";';
}

	
$style='&st='.$fstyle;


//enable autoplay
if($this->context->autoplay==true)
	{
		$autoplay='&auto=play';
		$html5autoplay=' setTimeout("this.'.$this->context->id.'.Play()",10);';
	}
	
//check playlist or video was set
if(!empty($this->context->video))
	{
		$playlist='&file='.$this->context->video;
		$html5='this.'.$this->context->id.' = new Uppod({m:"video",uid:"'.$this->context->id.'",file:"'.$this->context->video.'"});'.$hstyle.$html5autoplay;
	}
else
	{
		$html5='var yiipplaylist="'.$this->context->playlist.'";'.'this.'.$this->context->id.' = new Uppod({m:"video",uid:"'.$this->context->id.'", st:"yiipplaylist"});'.$hstyle.$html5autoplays;
		$playlist='&pl='.$this->context->playlist;
	}


	
	
	
//player code

echo '<object data="'.$this->context->swfUrl.'" type="application/x-shockwave-flash" height="'.(int)$this->context->height.'" width="'.(int)$this->context->width.'"><param value="'.$this->context->bgcolor.'" name="bgcolor"><param value="true" name="allowFullScreen"><param value="always" name="allowScriptAccess"><param value="'.$this->context->id.'" name="id"><param value="uid='.$this->context->id.$playlist.$style.$autoplay.'" name="flashvars"></object>
	
	  <script type="text/javascript">

		var ua = navigator.userAgent.toLowerCase();
		var flashInstalled = false;
		if (typeof(navigator.plugins)!="undefined" && typeof(navigator.plugins["Shockwave Flash"])=="object") { 
	         flashInstalled = true; 
		} else if (typeof  window.ActiveXObject !=  "undefined") { 
			try { 
				if (new ActiveXObject("ShockwaveFlash.ShockwaveFlash")) { 
					flashInstalled = true; 
				} 
			} catch(e) {}; 
		};
	      
	   if(ua.indexOf("iphone") != -1 || ua.indexOf("ipad") != -1 || (ua.indexOf("android") != -1 && !flashInstalled)){
	   
	   		// HTML5
			'.$html5.'
	   }else{
	      if(!flashInstalled){
	      	 // NO FLASH
	         document.getElementById("'.$this->context->id.'").innerHTML="<a href=http://www.adobe.com/go/getflashplayer>Please install Flash-player!</a>";
	         
	      }else{
	      	try{
	         // FLASH
	         var flashvars = {"file":"'.$this->context->video.'", "uid":"'.$this->context->id.'"};
	         var params = {bgcolor:"'.$this->context->bgcolor.'",  allowFullScreen:"true", allowScriptAccess:"always",id:"'.$this->context->id.'"};
	         new swfobject.embedSWF("'.  \usni\UsniAdaptor::app()->request->baseUrl.$this->context->swfUrl.'", "'.$this->context->id.'", "'.(int)$this->context->width.'", "'.(int)$this->context->height.'", "10.0.0", false, flashvars, params);
			}
			catch(e){}
	      }
	   }
	</script>';
?>