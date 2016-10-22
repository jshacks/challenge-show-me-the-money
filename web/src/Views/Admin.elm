module Views.Admin exposing (..)

import Html as H exposing (Html)
import Html.Attributes as A


type Msg
    = SetName String
    | SetPassword String
    | Submit


type alias Model =
    { name : String
    , password : String
    }


addEntity () =
    H.section [ A.class "add-entity-form form-s" ]
        [ H.h2 [] [ H.text "Add watcher or notifier" ]
        , H.input [ A.type' "text", A.placeholder "Name" ] []
        , H.input [ A.type' "text", A.placeholder "identifier / CUI" ] []
        , H.input [ A.type' "email", A.placeholder "Email" ] []
        , H.div [ A.class "role" ]
            [ H.span [] [ H.text "Role:" ]
            , H.label []
                [ H.input [ A.type' "radio" ] []
                , H.text "Watcher"
                ]
            , H.label []
                [ H.input [ A.type' "radio" ] []
                , H.text "Notifier"
                ]
            ]
        , H.button [ A.class "submit" ] [ H.text "Submit" ]
        ]
