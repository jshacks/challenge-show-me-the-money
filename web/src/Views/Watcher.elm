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


showDebtors =
    H.section [ A.class "debtors-table" ]
        [ H.h2 [] [ H.text "Debtors" ]
        , H.table []
            [ H.thead []
                [ H.tr []
                    [ H.th [] [ H.text "Name" ]
                    , H.th [] [ H.text "Surname" ]
                    , H.th [] [ H.text "Birth-date" ]
                    , H.th [] [ H.text "CNP" ]
                    , H.th [] [ H.text "Total Debt" ]
                    , H.th [] [ H.text "Debtor Details" ]
                    ]
                ]
            , H.tbody []
                [ H.tr []
                    [ H.td [] [ H.text "dummy Name" ]
                    , H.td [] [ H.text "dummy Surname" ]
                    , H.td [] [ H.text "dummy Birthdate" ]
                    , H.td [] [ H.text "1895245785" ]
                    , H.td [] [ H.text "10000 Lei" ]
                    , H.td [] [ H.button [] [ H.text "more / edit" ] ]
                    ]
                , H.tr []
                    [ H.td [] [ H.text "dummy Name" ]
                    , H.td [] [ H.text "dummy Surname" ]
                    , H.td [] [ H.text "dummy Birthdate" ]
                    , H.td [] [ H.text "1895245785" ]
                    , H.td [] [ H.text "10000 Lei" ]
                    , H.td [] [ H.button [] [ H.text "more / edit" ] ]
                    ]
                ]
            ]
        ]
