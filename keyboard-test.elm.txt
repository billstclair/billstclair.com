----------------------------------------------------------------------
--
-- keyboard-test.elm
-- Copyright (c) 2016 Bill St. Clair <billstclair@gmail.com>
-- Some rights reserved.
-- Distributed under the MIT License
-- See LICENSE.txt
--
----------------------------------------------------------------------

import Keyboard

import String
import Char
import Html exposing (Html, Attribute, div, text, h2, p, span)
import Html.Attributes exposing (style)
import Html.App as Html
import Debug exposing (log)

main =
  Html.program
    { init = init
    , view = view
    , update = update
    , subscriptions = subscriptions
    }

type alias Model =
  Int

model : Model
model = 0

type Msg =
  PressKey Int

init : (Model, Cmd Msg)
init = (model, Cmd.none)

update : Msg -> Model -> (Model, Cmd Msg)
update msg model =
  case msg of
      PressKey key ->
        (log "KeyCode:" key, Cmd.none)

subscriptions : Model -> Sub Msg
subscriptions model =
  Keyboard.presses (PressKey)

bold: Attribute a
bold =
  style [ ("fontWeight", "bold") ]

br : Html a
br =
  Html.br [] []

View : Model -> Html Msg
view model =
  div []
    [ h2 [] [ text "Elm Keyboard Test" ]
    , p [] [ span [ bold ] [ text "Code: " ]
           , text <| toString model
           , br
           , span [ bold ] [ text "Char: " ]
           , text <| String.fromList [ Char.fromCode model ]
           ]
    , p [] [ text "Press keys and their keycodes will appear above." ]
    , p [] [ text "Only the arrow keys work for me in Firefox." ]
    , p [] [ text "The arrow keys do NOT work for me in Safari, Chrome, or Opera,"
           , text "but the other keys DO work."
           ]
    ]
