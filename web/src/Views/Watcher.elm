module Views.Watcher exposing (..)

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


addDebtor =
    H.section [ A.class "add-debtor form-s" ]
        [ H.input [ A.type' "text", A.placeholder "Name" ] []
        , H.input [ A.type' "text", A.placeholder "Surname" ] []
        , H.input [ A.type' "date", A.placeholder "Birth Date" ] []
        , H.input [ A.type' "number", A.placeholder "CNP" ] []
        , H.input [ A.type' "number", A.placeholder "Total Debt" ] []
        , H.button [ A.class "submit" ] [ H.text "Add Debtor" ]
        ]
