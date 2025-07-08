from datetime import date, timedelta
from habit.models import Habit, HabitLog
from habit.utils.enums import HabitFrequency


def fill_missing_logs(habit):


    match habit.frequency:
        case HabitFrequency.DAILY.value:
            print("daily")
        case HabitFrequency.WEEKLY.value:
            print("weekly")
            if habit.has_pattern:
                print("pattern")
            else:
                print("no pattern")
        case HabitFrequency.MONTHLY.value:
            print("monthly")
            if habit.has_pattern:
                print("pattern")
            else:
                print("no pattern")

class CheckLogs:

    #TODO: create check logs methods

    def daily(self, habit):
        today = date.today()
        first_day = habit.created_at.date()

        logs = HabitLog.objects.all()
        new_logs = []

        current_day = first_day
        while current_day <= today:
            if current_day not in logs:
                new_logs.append(
                    HabitLog(
                        habit=habit,
                        date=current_day,
                        completion_state=0
                    )
                )
                current_day = current_day + timedelta(days=1)

        HabitLog.objects.bulk_create(new_logs)
    def weekly_with_pattern(self, habit):
        return None
    def weekly_no_pattern(self, habit):
        return None
    def month_with_pattern(self, habit):
        return None
    def month_no_pattern(self, habit):
        return None
