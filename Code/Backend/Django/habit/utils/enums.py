from enum import Enum


class HabitFrequency(Enum):
    DAILY = 'daily'
    WEEKLY = 'weekly'
    MONTHLY = 'monthly'


class HabitStates(Enum):
    TWO_STATE = 'two-state'
    FOUR_STATE = 'four-state'